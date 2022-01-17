<?php

namespace App\Http\Controllers\API\Common;

use Auth;
use App\Models\{Sale, SaleDetail, Status};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\{SaleResource, StatusResource};
use App\Http\Requests\Admin\SaleRequest;

class BaseSaleController extends Controller
{
    public function index()
    {
        $records = Sale::orderBy('created_at', 'desc')->get();
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
            // $this->updateInventory($record);
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
        // $sale->user_id              = Auth::id();
        $sale->customer_id          = $request->customer_id;
        // $sale->sale_invoice_no      = $this->getSalesInvoiceNo($request);
        $sale->save();

        return response() -> json([
            'status' => 1,
            'message' => 'Sale data has been updated',
            'data' => [
                'sale' => new SaleResource($sale)
            ]
        ], 200);           
    }  
    
    public function getLatestSaleInvoice()
    {
        $data       = Sale::where('proper_invoice', '=', 1)->latest()->first();
        $invoice_no = $data ? $data->sale_invoice_no + 1 : env('TAX_INVOICE_NO_START', 500);
        return response() -> json([
            'status' => 1,
            'message' => 'Latest invoice number',
            'data' => [
                'invoice_no' => $invoice_no
            ]
        ], 200);  
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

        return;
    }


}
