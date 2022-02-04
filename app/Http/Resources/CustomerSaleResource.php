<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerSaleResource extends JsonResource
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
            'sale_invoice_no'   => $this->sale_invoice_no,
            'type'              => $this->type,
            'proper_invoice'    => $this->proper_invoice,
            'created_at'        => date("d M Y, h:i A", strtotime($this->created_at))            
        ];
    }
}
