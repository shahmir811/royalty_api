<?php

namespace App\Http\Controllers\API\Common;

use Auth;
use Carbon\Carbon;
use App\Models\{Move, MoveDetail, Inventory, InventoryItemHistory};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\{MoveResource, MoveDetailResource};

class BaseMoveController extends Controller
{
    public function index() 
    {
        $moves = Move::orderBy('created_at', 'desc')->get();
        return response() -> json([
            'status' => 1,
            'message' => 'List of all movements',
            'data' => [
                'moves' => MoveResource::collection($moves)
            ]
        ], 200);         
    }

    public function moveInventoryItems(Request $request) 
    {
        // Subtract quantity from source location
        foreach ($request->records as $record) {
            $invt = Inventory::find($record['id']);
            $invt->quantity = $invt->quantity - $record['moveQuantity'];
            $invt->save();
        }   

        // Add Quantity to destination location
        foreach ($request->records as $record) {
            $invt = Inventory::where('location_id', '=', $request->destination_location_id)
                                ->where('item_id', '=', $record['item_id'])
                                ->first();

            // if record available in database
            if($invt) {
                $invt->quantity = $invt->quantity + $record['moveQuantity'];
                $invt->save();
            
            } else {
                $item = new Inventory;
                $item->item_id          = $record['item_id'];
                $item->quantity         = $record['moveQuantity'];
                $item->purchase_price   = 0;
                $item->avg_price        = 0;
                $item->sale_price       = 0;
                $item->location_id      = $request->destination_location_id;
                $item->save();
            }
        }  

        // Add move record to moves table
        $move = new Move;
        $move->from_location_id = $request->source_location_id;
        $move->to_location_id = $request->destination_location_id;
        $move->save();

        // Add record to move details table
        foreach ($request->records as $record) {
            $detail                 = new MoveDetail;
            $detail->move_id        = $move->id;
            $detail->inventory_id   = $record['id'];
            $detail->quantity       = $record['moveQuantity'];
            $detail->save();
        }           

        
        // Add inventory item history for move-out
        foreach ($request->records as $record) {
            $invt               = Inventory::find($record['id']);
            $invt_id            = $record['id'];
            $quantity           = $record['moveQuantity'];
            $description        = 'Moved out ' . $quantity . ' quantities to ' . $invt->location->name;
            $move_id            = $move->id;
            $move_invoice_no    = $move->move_invoice_no;
            $status             = 'MOVED OUT';

            $this->inventoryItemHistory($invt_id, $quantity, $description, $move_id, $move_invoice_no, $status);
        }   


        // Add inventory item history for move-in
        foreach ($request->records as $record) {
            $invt = Inventory::where('location_id', '=', $request->destination_location_id)
                                ->where('item_id', '=', $record['item_id'])
                                ->first();

            $invt_id            = $invt->id;
            $quantity           = $record['moveQuantity'];
            $description        = 'Moved in ' . $quantity . ' quantities from ' . $invt->location->name;
            $move_id            = $move->id;
            $move_invoice_no    = $move->move_invoice_no;
            $status             = 'MOVED IN';

            $this->inventoryItemHistory($invt_id, $quantity, $description, $move_id, $move_invoice_no, $status);

        }          


        return response() -> json([
            'status' => 1,
            'message' => 'Inventory items moved successfully',
        ], 200);             

    }

    public function moveDetails($move_id) 
    {
        // $details = moveDetails::where('move_id', '=', $move_id)->orderBy('created_at', 'desc')->get();
        $move = Move::findOrFail($move_id);
        return response() -> json([
            'status' => 1,
            'message' => 'Move details',
            'data' => [
                'move' => new MoveResource($move)
            ]
        ], 200);              
    }


    ////////////////////////////////////////////////////////////////////////////////////

    private function inventoryItemHistory($invt_id, $quantity, $description, $move_id, $move_invoice_no, $status)
    {
        $obj                        = new \stdClass();
        $obj->quantity              = $quantity;
        $obj->inventory_id          = $invt_id;
        $obj->description           = $description;
        $obj->status                = $status;
        $obj->purchase_id           = null;
        $obj->purchased_invoice_no  = null;
        $obj->sale_id               = null;
        $obj->sale_invoice_no       = null;
        $obj->move_id               = $move_id;
        $obj->move_invoice_no       = $move_invoice_no;        
        $obj->created_at            = Carbon::now();
        
        InventoryItemHistory::addNewHistoryRecord($obj);           

        return ;
    }

}
