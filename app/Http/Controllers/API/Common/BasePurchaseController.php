<?php

namespace App\Http\Controllers\API\Common;

use PDF;
use Carbon\Carbon;
use App\Models\{Purchase, PurchaseDetail, Inventory, Status, InventoryItemHistory};
use App\Http\Resources\PurchaseResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BasePurchaseController extends Controller
{
    public function purchaseList ()
    {
        $records = Purchase::orderBy('created_at', 'desc')->get();
        return response() -> json([
            'status' => 1,
            'message' => 'List of all purchases',
            'data' => [
                'purchases' => PurchaseResource::collection($records)
            ]
        ], 200);             
    }

    public function addNewPurchase(Request $request) 
    {
        $purchase = new Purchase;
        $purchase->local_purchase = $request->local_purchase;
        $purchase->total_amount = $request->total_amount;
        $purchase->save();

        foreach ($request->details as $record) {
            $this->addPurchaseDetails($purchase->id, $record);
            // $this->updateInventory($record);
        }

        return response() -> json([
            'status' => 1,
            'message' => 'Purchase record has been saved'
        ], 200);       

    }

    public function updatePurchase(Request $request, $id)
    {
        $purchase                   = Purchase::findOrFail($id);
        $purchase->local_purchase   = $request->local_purchase;
        $purchase->total_amount     = $request->total_amount;
        $purchase->save();

        foreach ($request->details as $record) {
            if($record['id']) {
                $this->updatePurchaseDetails($purchase->id, $record);
            } else {
                $this->addPurchaseDetails($purchase->id, $record);
            }
        }

        return response() -> json([
            'status' => 1,
            'message' => 'Purchase record has been updated'
        ], 200);            

    }

    public function showPurchase($id) {
        $purchase = Purchase::findOrFail($id);
        return response() -> json([
            'status' => 1,
            'message' => 'Purchase details',
            'data' => [
                'purchase' => new PurchaseResource($purchase)
            ]
        ], 200);           

    }

    public function removePurchasedItem($id) 
    {
        $item           = PurchaseDetail::findOrFail($id);
        $item_quantity  = $item->quantity;
        $item_price     = $item->price; 
        $purchase_id    = $item->purchase_id;

        // $this->resetItemAvgPrice($item->inventory_id, $item_quantity, $item_price);
        $item->delete();

        $purchase               = Purchase::findOrFail($purchase_id);
        $purchase->total_amount = $purchase->total_amount - ($item_price * $item_quantity);
        $purchase->save();
        return response() -> json([
            'status' => 1,
            'message' => 'Purchased item has been removed',
            'data' => [
                'purchase' => new PurchaseResource($purchase)
            ]
        ], 200);                      

    }

    public function changePurchaseStatus($id)
    {
        $purchase = Purchase::findOrFail($id);

        foreach ($purchase->purchases as $record) {
            $this->adjustInventory($record, $purchase->id);
        }

        $received_status_id     = Status::where('name', '=', 'Received')->where('type', '=', 'purchase')->pluck('id');
        $purchase->status_id    =  $received_status_id[0];
        $purchase->save();

        return response() -> json([
            'status' => 1,
            'message' => 'Purchase status has been updated',
        ], 200);             

    }

    public function removePurchaseRecord($id)
    {
        $purchase = Purchase::findOrFail($id);

        foreach ($purchase->purchases as $record) {
            $record->delete();
        }

        $purchase->delete();
        
        return response() -> json([
            'status' => 1,
            'message' => 'Purchase record has been removed',
        ], 200);             

        
    }

    public function printPurchaseDetails($id)
    {
        $purchase = Purchase::findOrFail($id);
        $pdf = PDF::loadView('pdfs.purchaseDetails', compact(['id', 'purchase']));
        $pdf->setPaper('a4' , 'portrait');
        return $pdf->output();  
    }

    private function addPurchaseDetails($purchase_id, $data)
    {
        $detail                 = new PurchaseDetail;
        $detail->price          = $data['price'];
        $detail->quantity       = $data['quantity'];
        $detail->total_price    = $data['price'] * $data['quantity'];
        $detail->item_id        = $data['item_id'];
        $detail->location_id    = $data['location_id'];
        $detail->purchase_id    = $purchase_id;
        $detail->save();
    }

    private function updatePurchaseDetails($purchase_id, $data)
    {
        $detail                 = PurchaseDetail::findOrFail($data['id']);
        $detail->price          = $data['price'];
        $detail->quantity       = $data['quantity'];
        $detail->total_price    = $data['price'] * $data['quantity'];
        $detail->item_id        = $data['item_id'];
        $detail->location_id    = $data['location_id'];
        $detail->purchase_id    = $purchase_id;
        $detail->save();        
    }

    private function resetItemAvgPrice($invtId, $item_quantity, $item_price)
    {
        $invt           = Inventory::findOrFail($invtId);
        $current_value  = $invt->quantity * $invt->avg_price;
        $item_value     = $item_quantity * $item_price;

        $current_avg        = ($current_value - $item_value) / ($invt->quantity - $item_quantity); 
        $invt->avg_price    = $current_avg;
        $invt->quantity     = $invt->quantity - $item_quantity;
        $invt->save();

    }

    private function updateInventory($data)
    {
        $item = Inventory::findOrFail($data['inventory_id']);
        $item->avg_price = $this->calculateAverage($item, $data);
        $item->purchase_price = $data['price'];
        $item->quantity += $data['quantity'];
        $item->save();
    }

    private function calculateAverage(Inventory $item, $data)
    {
        $newTotal = $data['price'] * $data['quantity']; // 1080
        $itemsTotal = $item->quantity * $item->avg_price; // 0
        $total_quantity = $item->quantity + $data['quantity']; // 10
        
        $avg = ($newTotal + $itemsTotal) / $total_quantity; // 108
        return $avg;
    }

    private function adjustInventory(PurchaseDetail $detail, $purchase_id)
    {
        $inventory = Inventory::where('location_id', '=', $detail->location_id)->where('item_id', '=', $detail->item_id)->first();

        if($inventory) {
            $inventory->avg_price = $this->updateItemAveragePrice($inventory, $detail->quantity,  $detail->price);
            $inventory->purchase_price = $detail->price;
            $inventory->quantity += $detail->quantity;
            $inventory->save();
        
        } else {
            $invt                   = new Inventory;
            $invt->location_id      = $detail->location_id;
            $invt->item_id          = $detail->item_id;
            $invt->purchase_price   = $detail->price;
            $invt->sale_price       = $detail->price;
            $invt->avg_price        = $detail->price;
            $invt->quantity         = $detail->quantity;
            $invt->save();            

        }

        // TODO: Add Inventory history item

        $obj                        = new \stdClass();
        $obj->quantity              = $detail->quantity;
        $obj->inventory_id          = $inventory->id;
        $obj->description           = "Purchased " . $detail->quantity ." items at price: " . $detail->price . " each.";
        $obj->status                = "PURCHASED";
        $obj->purchase_id           = $purchase_id;
        $obj->purchased_invoice_no  = $detail->purchase->purchase_invoice_no;
        $obj->sale_id               = null;
        $obj->sale_invoice_no       = null;
        $obj->move_id               = null;
        $obj->move_invoice_no       = null;        
        $obj->created_at            = Carbon::now();
        
        InventoryItemHistory::addNewHistoryRecord($obj);           

        return ;
    }

    private function updateItemAveragePrice(Inventory $inventory, $newQuantity, $newPrice) 
    {
        $totalValue         = $inventory->quantity * $inventory->avg_price + $newQuantity * $newPrice;
        $totalQuantity      = $inventory->quantity + $newQuantity;
        $avgPrice           = $totalValue / $totalQuantity;
        
        return $avgPrice;
    }
}
