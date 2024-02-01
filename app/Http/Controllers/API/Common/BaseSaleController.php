<?php

namespace App\Http\Controllers\API\Common;

use Auth;
use PDF;
use Carbon\Carbon;
use App\Models\{Sale, SaleDetail, Status, Inventory, PredefinedValue, InventoryItemHistory, Credit, Payment};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\{SaleResource, StatusResource, SaleDetailResource};
use App\Http\Requests\Admin\SaleRequest;

class BaseSaleController extends Controller
{
    public function index()
    {
        $showTax = PredefinedValue::findOrFail(1);

        $records;

        if($showTax->show_tax) {
            $records = Sale::orderBy('created_at', 'desc')->get();
        } else {
            $records = Sale::where('proper_invoice', '=', 1)->orderBy('created_at', 'desc')->get();
        }

        return response() -> json([
            'status' => 1,
            'message' => 'Sales list',
            'data' => [
                'sales' => SaleResource::collection($records)
            ]
        ], 200);        
    }

    public function salesWithDeliveryNotes()
    {
        $showTax = PredefinedValue::findOrFail(1);

        $records;

        if($showTax->show_tax) {
            $records = Sale::where('make_delivery_note', '=', 1)->orderBy('created_at', 'desc')->get();
        } else {
            $records = Sale::where('proper_invoice', '=', 1)
                            ->where('make_delivery_note', '=', 1)
                            ->orderBy('created_at', 'desc')
                            ->get();
        }

        return response() -> json([
            'status' => 1,
            'message' => 'Sales list',
            'data' => [
                'sales' => SaleResource::collection($records)
            ]
        ], 200);        
    }    

    public function addNewSale (SaleRequest $request)
    {      

        $sale                       = new Sale;
        $sale->total_sale_price     = $request->total_sale_price;
        $sale->total_avg_price      = $request->total_avg_price;
        $sale->extra_charges        = $request->extra_charges;
        $sale->total_tax            = $request->total_tax;
        $sale->tax_percent          = $request->tax_percent;
        $sale->payment_mode         = $request->payment_mode;
        $sale->contact_no           = $request->contact_no;
        $sale->make_delivery_note   = $request->make_delivery_note;
        $sale->shipping_location    = $request->shipping_location;
        $sale->type                 = $request->type;
        $sale->quotation            = $request->quotation;
        $sale->user_id              = Auth::id();
        $sale->customer_id          = $request->customer_id;
        $sale->save();

        // If the sale is actual (means not sale quotation) and payment mode is credit then add customer credit details
        if ($sale->sale_invoice_no && $sale->payment_mode == 'Credit') {
            $currentDate = Carbon::now();
            $newDate = $currentDate->addDays(30);

            $credit                     = new Credit;
            $credit->customer_id        = $request->customer_id;
            $credit->sale_id            = $sale->id;
            $credit->due_date           = $request->dueDate ? $request->dueDate : $newDate;
            // $credit->due_amount         = $sale->total_sale_price;
            // $credit->total_amount_paid  = $sale->total_sale_price;
            $credit->due_amount         = $sale->total_tax  + $sale->total_sale_price;
            $credit->total_amount_paid  = $sale->total_tax  + $sale->total_sale_price;
            $credit->save();            
        }

        foreach ($request->details as $record) {
            $this->addSaleDetails($sale->id, $record);
        }        

        return response() -> json([
            'status' => 1,
            'message' => 'Sale record has been saved'
        ], 200);              
    }

    public function showSaleDetails($id)
    {
        $record = Sale::findOrFail($id);
        return response() -> json([
            'status' => 1,
            'message' => 'Sale details',
            'data' => [
                'sale' => new SaleResource($record)
            ]
        ], 200);            
    }

    public function fetchAllSalesStatus()
    {
        $records = Status::where('type', '=', 'sales')->get();
        return response() -> json([
            'status' => 1,
            'message' => 'Sale details',
            'data' => [
                'statuses' => StatusResource::collection($records)
            ]
        ], 200);              
    }

    public function updateSaleRecord (SaleRequest $request, $id)
    {
        $delivered_status           = Status::where('name', '=', 'Delivered')->where('type', '=', 'sales')->first();
        $cancelled_status           = Status::where('name', '=', 'Cancelled')->where('type', '=', 'sales')->first();
        $pending_status             = Status::where('name', '=', 'Pending')->where('type', '=', 'sales')->first();

        $sale                       = Sale::findOrFail($id);
        $sale->sale_invoice_no      = $request->sale_invoice_no;
        $sale->extra_charges        = $request->extra_charges;
        $sale->total_tax            = $request->total_tax;
        $sale->make_delivery_note   = $request->make_delivery_note;
        $sale->tax_percent          = $request->tax_percent;
        $old_payment_mode           = $sale->payment_mode;
        $new_payment_mode           = $request->payment_mode;
        $sale->payment_mode         = $request->payment_mode;
        $sale->contact_no           = $request->contact_no;
        $sale->shipping_location    = $request->shipping_location;
        $sale->type                 = $request->type;
        $old_status                 = $sale->status_id;
        $sale->status_id            = $request->status_id;
        $new_status                 = $request->status_id;
        $sale->quotation            = $request->quotation;
        $sale->customer_id          = $request->customer_id;

        if($request->status_id != $pending_status->id && $sale->received_by == '') {
            $username = Auth::user()->name;
            $sale->received_by = $username;
        }

        if($request->status_id == $cancelled_status->id) {
            $sale->cancelled_by = Auth::user()->name;
        }

        $sale->save();

        // if sale status is delivered, then update inventory
        if($sale->status_id == $delivered_status->id) {
            $this->updateInventory($sale->id);
            $this->addInventoryItemHistory($sale->id, $sale->sale_invoice_no);
        }

        // if status is changed from delivered to cancelled, then we have to move all the items to the inventory
        if($old_status == $delivered_status->id && $new_status != $delivered_status->id) {
            $this->moveBackItemsToInventory($sale->id);
            $this->removeInventoryItemHistory($sale->id, $sale->sale_invoice_no);
        }

        // if old_payment_mode was credit and the new_payment_mode is not credit,
        // then remove all payments and credit history
        if($old_payment_mode == 'Credit' && $new_payment_mode != 'Credit') {
            $this->removeCustomerPaymentsAndCredit($sale);
        }

        // if old_payment_mode was not credit and the new_payment_mode is credit,
        // then add customer credit history
        if($old_payment_mode != 'Credit' && $new_payment_mode == 'Credit') {
            $this->addCustomerCredit($sale);
        }
        

        return response() -> json([
            'status' => 1,
            'message' => 'Sale data has been updated',
            'data' => [
                'sale' => new SaleResource($sale)
            ]
        ], 200);           
    }  
    
    public function getSaleInvoice($id)
    {
        $invoice_no;
        $saleRecord = Sale::findOrFail($id);

        if(!$saleRecord->sale_invoice_no && $saleRecord->proper_invoice) {
            $invoice_no = $saleRecord->getSaleSeries('T');
    
        } else {
            $invoice_no = $saleRecord->getSaleSeries('N');
        
        }        

        return response() -> json([
            'status' => 1,
            'message' => 'Latest invoice number',
            'data' => [
                'invoice_no' => $invoice_no
            ]
        ], 200);  
    }

    public function addSaleDetailItem(Request $request)
    {
        $data = $this->addSaleDetails($request->sale_id, $request);      

        $this->recalculateAvgAndSalePrice($data->sale_id, $request->tax);

        $this->updateCustomerCredit($request->sale_id);

        return response() -> json([
            'status' => 1,
            'message' => 'Sale Detail Item details have been added',
            'data' => [
                'detail' => new SaleDetailResource($data)
            ]
        ], 200);            
    }

    public function updateSaleDetailItem(Request $request, $id)
    {
        $data               = SaleDetail::findOrFail($id);
        $data->avg_price    = $request->avg_price;
        $data->sale_price   = $request->sale_price;
        $data->quantity     = $request->quantity;

        $data->total_avg_price  = $request->avg_price * $request->quantity;
        $data->total_sale_price = $request->sale_price * $request->quantity;    
        $data->save();    

        $this->recalculateAvgAndSalePrice($data->sale_id, $request->tax);
        $this->updateCustomerCredit($data->sale_id);

        return response() -> json([
            'status' => 1,
            'message' => 'Sale Detail Item details have been updated',
            'data' => [
                'detail' => new SaleDetailResource($data),
            ]
        ], 200);         

    }

    public function removeSaleDetailItem($id)
    {
        $data   = SaleDetail::findOrFail($id);
        $record = Sale::findOrFail($data->sale_id);
        $data->delete();

        $this->recalculateAvgAndSalePrice($record->id, $record->tax_percent);
        $this->updateCustomerCredit($data->sale_id);

        return response() -> json([
            'status' => 1,
            'message' => 'Sale Detail Item has been removed',
        ], 200);            

    }

    public function printSaleDetails($id)
    {
        // dd(class_exists('DOMDocument'));
        // return response() -> json([
        //     'status' => 1,
        //     'message' => 'Sale Detail Item has been removed',
        //     'exists' => class_exists('DOMDocument')
        // ], 200);            


        $today = Carbon::now()->format('d/m/Y');
        $sale = Sale::findOrFail($id);
        $pdf = PDF::loadView('pdfs.saleDetails', compact('id', 'sale', 'today'));
        $pdf->setPaper('a4' , 'portrait');
        return $pdf->output();        
    }

    private function moveBackItemsToInventory($sale_id)
    {
        $records   = SaleDetail::where('sale_id', '=', $sale_id)->get();

        if(sizeof($records) > 0) {
            foreach($records as $record) {
                $inventory = Inventory::findOrFail($record->inventory_id);
                $inventory->quantity += $record->quantity;
                $inventory->save();
            }            
        }

        return;        
    }

    private function updateInventory($sale_id)
    {
        $records   = SaleDetail::where('sale_id', '=', $sale_id)->get();

        if(sizeof($records) > 0) {
            foreach($records as $record) {
                $inventory = Inventory::findOrFail($record->inventory_id);
                $inventory->quantity -= $record->quantity;
                $inventory->save();
            }            
        }

        return;
    }

    private function addSaleDetails($sale_id, $data)
    {
        $detail                         = new SaleDetail;
        $detail->avg_price              = $data['avg_price'];
        $detail->sale_price             = $data['sale_price'];
        $detail->quantity               = $data['quantity'];
        
        $detail->total_avg_price        = $data['avg_price'] * $data['quantity'];
        $detail->total_sale_price       = $data['sale_price'] * $data['quantity'];
        
        $detail->location_id            = $data['location_id'];
        $detail->inventory_id           = $data['inventory_id'];
        $detail->sale_id                = $sale_id;
        $detail->save();

        return $detail;
    }


    private function recalculateAvgAndSalePrice($sale_id, $tax_percent)
    {
        $records = SaleDetail::where('sale_id', '=', $sale_id)->get();

        if(sizeof($records) > 0) {
            $total_sale_price = 0;
            $total_avg_price = 0;

            foreach($records as $record) {
                $total_sale_price += $record->total_sale_price;
                $total_avg_price += $record->total_avg_price;
            }

            $sale                   = Sale::findOrFail($sale_id);
            $sale->total_sale_price = $total_sale_price;
            $sale->total_avg_price  = $total_avg_price;
            $sale->tax_percent      = $tax_percent;
            $sale->total_tax        = $tax_percent == 0 ? 0 : $total_sale_price * $tax_percent / 100;
            $sale->save();
        
        } else {
            $sale                   = Sale::findOrFail($sale_id);
            $sale->total_sale_price = 0;
            $sale->total_avg_price  = 0;
            $sale->tax_percent      = $tax_percent;
            $sale->total_tax        = 0;
            $sale->save();

        }
    }

    private function addInventoryItemHistory($sale_id, $sale_invoice_no)
    {
        $details = SaleDetail::where('sale_id', '=', $sale_id)->get();

        foreach ($details as $detail) {

            $obj                        = new \stdClass();
            $obj->quantity              = $detail->quantity;
            $obj->inventory_id          = $detail->inventory_id;
            $obj->description           = "Sold " . $detail->quantity ." items at price: " . $detail->sale_price . " each.";
            $obj->status                = "SOLD";
            $obj->purchase_id           = null;
            $obj->purchased_invoice_no  = null;
            $obj->sale_id               = $sale_id;
            $obj->sale_invoice_no       = $detail->sale->sale_invoice_no;
            $obj->move_id               = null;
            $obj->move_invoice_no       = null;               
            $obj->created_at            = $detail->created_at;

            InventoryItemHistory::addNewHistoryRecord($obj);        
        }

        return;
    }


    private function removeInventoryItemHistory($sale_id, $sale_invoice_no)
    {
        InventoryItemHistory::where('status', '=', 'SOLD')->where('sale_invoice_no', '=', $sale_invoice_no)->delete();
        return;
    }

    private function updateCustomerCredit($sale_id)
    {
        // Add customer credit if sale payment mode is credit
        $sale = Sale::findOrFail($sale_id);

        if($sale->payment_mode == 'Credit') {
            $customerCredit = Credit::where('sale_id', '=', $sale->id)
                                    ->where('customer_id', '=', $sale->customer_id)
                                    ->first();                                 

            if($customerCredit) {

                $paymentsSum = Payment::where('credit_id', $customerCredit->id)
                                        ->sum('amount');

                
                $customerCredit->due_amount = $sale->total_tax + $sale->total_sale_price - $paymentsSum;
                $customerCredit->total_amount_paid = $sale->total_tax + $sale->total_sale_price;
                $customerCredit->save();
            }
        }    
        
        return;
    }

    private function removeCustomerPaymentsAndCredit(Sale $sale)
    {
        $customerCredit = Credit::where('sale_id', '=', $sale->id)
                                ->where('customer_id', '=', $sale->customer_id)
                                ->first();
                                
        if($customerCredit) {
            Payment::where('credit_id', $customerCredit->id)->delete();
            $customerCredit->delete();
        }

        return;
    }

    private function addCustomerCredit(Sale $sale)
    {
        $currentDate = Carbon::now();
        $newDate = $currentDate->addDays(30);

        $credit                     = new Credit;
        $credit->customer_id        = $sale->customer_id;
        $credit->sale_id            = $sale->id;
        $credit->due_date           = $newDate;
        $credit->due_amount         = $sale->total_tax  + $sale->total_sale_price;
        $credit->total_amount_paid  = $sale->total_tax  + $sale->total_sale_price;
        $credit->save();    
        
        return;
    }
 
}
