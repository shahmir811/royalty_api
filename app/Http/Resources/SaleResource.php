<?php

namespace App\Http\Resources;

use App\Models\Status;
use App\Http\Resources\SaleDetailResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'                        => $this->id,
            'sale_invoice_no'           => $this->sale_invoice_no,
            'type'                      => $this->type,
            'proper_invoice'            => $this->proper_invoice,
            'customer_id'               => $this->customer_id,
            'customer_name'             => $this->customer->name,
            'customer_trn'              => $this->customer->trn,
            'total_avg_price'           => number_format($this->total_avg_price,2),
            'total_sale_price'          => number_format($this->total_sale_price,2),
            'extra_charges'             => number_format($this->extra_charges,2),
            'total_tax'                 => number_format($this->total_tax,2),
            'tax_percent'               => $this->tax_percent,
            'contact_no'                => $this->contact_no,
            'shipping_location'         => $this->shipping_location,
            'quotation'                 => $this->quotation ? 'Yes' : 'No',
            'status_id'                 => $this->status_id,
            'payment_mode'              => $this->payment_mode,
            'status'                    => $this->status->name,
            'created_by'                => $this->user->name,
            'received_by'               => $this->received_by,
            'cancelled_by'              => $this->cancelled_by,
            'make_delivery_note'        => $this->make_delivery_note,
            'quotation_invoice_no'      => $this->quotation_invoice_no,
            'details'                   => SaleDetailResource::collection($this->sales),
            'delivery_notes'            => $this->delivery_notes->count(),
            'margin'                    => !$this->total_avg_price || !$this->total_sale_price ? 0 : $this->calculateMargin($this->status_id, $this->total_sale_price, $this->total_avg_price),
            'profit_amount'             => !$this->total_avg_price || !$this->total_sale_price ? 0 : $this->calculateProfitAmount($this->status_id, $this->total_sale_price, $this->total_avg_price),
            'created_at'                => date("d M Y, h:i A", strtotime($this->created_at)),    
        ];
    }

    private function calculateMargin($status_id, $sale_price, $avg_price)
    {
        $cancelled_status   = Status::where('name', '=', 'Cancelled')->where('type', '=', 'sales')->first();
        if($status_id == $cancelled_status->id) {
            return number_format(0,2);
        }

        $result = ($sale_price - $avg_price) / $avg_price * 100;
        return number_format($result,2);
    }

    private function calculateProfitAmount($status_id, $sale_price, $avg_price)
    {
        $cancelled_status   = Status::where('name', '=', 'Cancelled')->where('type', '=', 'sales')->first();
        if($status_id == $cancelled_status->id) {
            return number_format(0,2);
        }

        $result = ($sale_price - $avg_price);
        return number_format($result,2); 
    }
}
