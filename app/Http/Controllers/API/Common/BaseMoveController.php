<?php

namespace App\Http\Controllers\API\Common;

use App\Models\{Move, MoveDetail, Inventory};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\MoveResource;

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
        
        return response() -> json([
            'status' => 1,
            'message' => 'Inventory items moved successfully',
        ], 200);             

    }

}
