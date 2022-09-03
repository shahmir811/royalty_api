<?php

namespace App\Http\Controllers\API\Common;

use DB;
use App\Models\{DeliveryNote, DeliveryNoteDetails, SaleDetail};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DeliveryNoteResource;

class BaseDeliveryNote extends Controller
{
    public function allDeliveryNotes() 
    {        
        $notes = DeliveryNote::orderBy('created_at', 'desc')->get();
        return response() -> json([
            'status' => 1,
            'message' => 'List of all delivery notes',
            'data' => [
                'notes' => DeliveryNoteResource::collection($notes)
            ]
        ], 200); 
    }

    public function createDeliveryNote(Request $request) 
    {
        $note = new DeliveryNote();
        $note->sale_id = $request->sale_id;
        $note->save();

        foreach ($request->details as $record) {
            $this->addDeliveryNoteDetails($record, $note->id, $request->sale_id);
        }   
        
        $is_completed = true;
        $records = $this->remainingItems($request->sale_id);

        foreach ($records as $record) {
            $remaining = (int)$record->remaining;
            if($remaining > 0) {
                $is_completed = false;
                break;
            }
        }   

        $note->is_completed = $is_completed;
        $note->save();
        


        return response() -> json([
            'status' => 1,
            'message' => 'New Delivery Note added succesfully',
            
        ], 200);          
    }

    public function viewDeliveryNote($id) 
    {
        $note = DeliveryNote::findOrFail($id);

        // return response() -> json([
        //     'status' => 1,
        //     'message' => 'View delivery note details',
        //     'data' => [
        //         'note' => new DeliveryNoteResource($note)
        //     ]
        // ], 200);         
    }


    private function addDeliveryNoteDetails($data, $delivery_note_id, $sale_id)
    {
        $detail                     = new DeliveryNoteDetails();
        $detail->delivery_note_id   = $delivery_note_id;
        $detail->sale_id            = $sale_id;
        $detail->location_id        = $data['location_id'];
        $detail->inventory_id       = $data['inventory_id'];
        $detail->quantity           = $data['quantity'];
        $detail->save();

        return $detail;

    }

    public function remainingQuantityToDispatch($sale_id)
    {                    
        return response() -> json([
            'status' => 1,
            'message' => 'Remaining Items to dispatch',
            'data' => [
                'record' => $this->remainingItems($sale_id)
            ]
        ], 200);                        

    }

    private function remainingItems($sale_id) 
    {
        $record = SaleDetail::join
            ('delivery_note_details', 'delivery_note_details.inventory_id', '=', 'sale_details.inventory_id')
            ->select('sale_details.inventory_id', 'sale_details.quantity', DB::raw('SUM(delivery_note_details.quantity) as sold'), DB::raw('sale_details.quantity - SUM(delivery_note_details.quantity) as remaining'))
            ->where('sale_details.sale_id', '=', $sale_id)
            ->groupBy('sale_details.inventory_id', 'sale_details.quantity') 
            ->get();    

        return $record;
    }

    
}
