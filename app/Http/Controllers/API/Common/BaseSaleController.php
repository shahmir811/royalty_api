<?php

namespace App\Http\Controllers\API\Common;

use Auth;
use PDF;
use App\Models\{Sale, SaleDetail, Status, Inventory};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\{SaleResource, StatusResource, SaleDetailResource};
use App\Http\Requests\Admin\SaleRequest;

class BaseSaleController extends Controller
{
    public function index()
    {
        $records = Sale::orderBy('created_at', 'desc')->orderBy('created_at', 'desc')->get();
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
        $sale->contact_no           = $request->contact_no;
        $sale->shipping_location    = $request->shipping_location;
        $sale->type                 = $request->type;
        $sale->quotation            = $request->quotation;
        $sale->user_id              = Auth::id();
        $sale->customer_id          = $request->customer_id;
        $sale->save();

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
        $sale                       = Sale::findOrFail($id);
        // $sale->total_sale_price     = $request->total_sale_price;
        // $sale->total_avg_price      = $request->total_avg_price;
        $sale->sale_invoice_no      = $request->sale_invoice_no;
        $sale->extra_charges        = $request->extra_charges;
        $sale->total_tax            = $request->total_tax;
        $sale->tax_percent          = $request->tax_percent;
        $sale->contact_no           = $request->contact_no;
        $sale->shipping_location    = $request->shipping_location;
        $sale->type                 = $request->type;
        $sale->status_id            = $request->status_id;
        $sale->quotation            = $request->quotation;
        $sale->customer_id          = $request->customer_id;
        $sale->save();

        // if sale status is deleivered, then update inventory
        if($sale->status_id == 4) {
            $this->updateInventory($sale->id);
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

        if($saleRecord->proper_invoice) {
            $data       = Sale::where('proper_invoice', '=', 1)->where('sale_invoice_no', '<>', null)->latest()->first();
            $invoice_no = $data ? $data->sale_invoice_no + 1 : env('TAX_INVOICE_NO_START', 500);
        
        } else {
            $invoice_no = time() . 's';
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

        return response() -> json([
            'status' => 1,
            'message' => 'Sale Detail Item has been removed',
        ], 200);            

    }

    public function printSaleDetails($id)
    {
        $pdf = PDF::loadView('pdfs.saleDetails', compact('id'));
        $pdf->setPaper('a4' , 'portrait');
        return $pdf->output();        
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

}
