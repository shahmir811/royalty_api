<?php

namespace App\Http\Controllers\API\Common;

use DB;
use PDF;
use Carbon\Carbon;
use App\Models\{DeliveryNote, DeliveryNoteDetails, SaleDetail, Sale};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DeliveryNoteResource;
use App\Http\Requests\Admin\CreateDeliveryNoteRequest;

class BaseDeliveryNote extends Controller
{
    public function allDeliveryNotes(Request $request) 
    {        
        $notes = DeliveryNote::where('sale_id', '=', $request->sale_id)->orderBy('created_at', 'desc')->get();
        return response() -> json([
            'status' => 1,
            'message' => 'List of all delivery notes',
            'data' => [
                'notes' => DeliveryNoteResource::collection($notes)
            ]
        ], 200); 
    }

    public function createDeliveryNote(CreateDeliveryNoteRequest $request) 
    {
        $note                       = new DeliveryNote();
        $note->sale_id              = $request->sale_id;
        $note->contact_no           = $request->contact_no;
        $note->shipping_location    = $request->shipping_location;
        $note->save();

        foreach ($request->details as $record) {
            $this->addDeliveryNoteDetails($record, $note->id, $request->sale_id);
        }        

        return response() -> json([
            'status' => 1,
            'message' => 'New Delivery Note added succesfully',
            
        ], 200);          
    }

    public function viewDeliveryNote($id) 
    {
        $note = DeliveryNote::findOrFail($id);
  
    }

    public function printDeliveryNote($id)
    {
        $today = Carbon::now()->format('d/m/Y');
        $note = DeliveryNote::findOrFail($id);
        $sale = Sale::findOrFail($note->sale_id);
        $this->calculatePackages($note);
        $pdf = PDF::loadView('pdfs.deliveryNote', compact('id', 'sale', 'today', 'note'));
        $pdf->setPaper('a4' , 'portrait');
        return $pdf->output();        
    }


    private function addDeliveryNoteDetails($data, $delivery_note_id, $sale_id)
    {
        if($data['add'] !== 0) {
            $detail                     = new DeliveryNoteDetails();
            $detail->delivery_note_id   = $delivery_note_id;
            $detail->sale_id            = $sale_id;
            $detail->location_id        = $data['location_id'];
            $detail->inventory_id       = $data['inventory_id'];
            $detail->quantity           = $data['add'];
            $detail->save();

            return $detail;

        }

    }

    public function remainingQuantityToDispatch($sale_id)
    { 
        $records    = $this->remainingItems($sale_id);
        $dispatched = $this->items_already_dispatched($sale_id);

        // Convert Eloquent Collection to plain array
        $dispatched = json_decode(json_encode($dispatched), true);        
    
        foreach ($records as &$record) {
            $matchingDispatch = array_values(array_filter($dispatched, function ($dispatch) use ($record) {
                return $dispatch["inventory_id"] === $record["inventory_id"];
            }));

            if (!empty($matchingDispatch)) {
                $record["items_already_dispatched"]         = $matchingDispatch[0]["items_already_dispatched"];
                $record["remaining_items_to_dispatched"]    = $record["quantity"] - (int)$record["items_already_dispatched"];
            }
        }


        return response() -> json([
            'status' => 1,
            'message' => 'Remaining Items to dispatch',
            'data' => [
                'record' => $records,
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

    private function calculatePackages ($note)
    {
        foreach ($note->delivery_note_details as $detail) {
            $detail['packages'] = $detail->quantity * $detail->inventory->item->package;
        }        

        return;
    }

    private function items_already_dispatched($sale_id)
    {
        return DeliveryNoteDetails::select('inventory_id', DB::raw('SUM(quantity) as items_already_dispatched'))
            ->where('sale_id', '=', $sale_id)
            ->groupBy('inventory_id') 
            ->get(); 
            
    }


}
