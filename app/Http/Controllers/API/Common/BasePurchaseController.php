<?php

namespace App\Http\Controllers\API\Common;

use App\Models\{Purchase, PurchaseDetail};
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

        // for ($x = 0; $x < $request->details; $x++) {
        //     $this->addPurchaseDetails($purchase->id, $request->details[$x]);
        // }
        foreach ($request->details as $record) {
            $this->addPurchaseDetails($purchase->id, $record);
        }

        return response() -> json([
            'status' => 1,
            'message' => 'Purchase record has been saved'
        ], 200);       

    }

    private function addPurchaseDetails($id, $data)
    {
        $detail = new PurchaseDetail;
        $detail->price = $data['price'];
        $detail->quantity = $data['quantity'];
        $detail->total_price = $data['price'] * $data['quantity'];
        $detail->inventory_id = $data['inventory_id'];
        $detail->location_id = $data['location_id'];
        $detail->purchase_id = $data['purchase_id'];
        $detail->save();

    }
}
