<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerCreditResource extends JsonResource
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
            'id'                => $this->id,
            'customer_name'     => $this->customer->name,
            'customer_id'       => $this->customer_id,
            'sale_id'           => $this->sale_id,
            'sale_invoice_no'   => $this->sale->sale_invoice_no,
            'sale_date'         => date("d M Y, h:i A", strtotime($this->sale->created_at)),
            'due_amount'        => number_format($this->due_amount, 2),
            'total'             => number_format($this->total_amount_paid, 2),
            
        ];
    }
}
