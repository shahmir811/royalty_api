<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryNoteResource extends JsonResource
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
            'delivery_note_no'          => $this->delivery_note_no,
            'contact_no'                => $this->contact_no,
            'shipping_location'         => $this->shipping_location,
            'sale_contact_no'           => $this->sale->contact_no,
            'sale_shipping_location'    => $this->sale->shipping_location,            
            'sale_id'                   => $this->sale_id,
            'sale_invoice_no'           => $this->sale->sale_invoice_no,
            'details'                   => $this->deliver,
            'created_at'                => date("d M Y, h:i A", strtotime($this->created_at)),  
            'details'                   => DeliveryNoteDetailsResource::collection($this->delivery_note_details),
        ];
    }
}
