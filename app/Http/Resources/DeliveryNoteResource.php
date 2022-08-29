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
            'id'                    => $this->id,
            'delivery_note_no'      => $this->delivery_note_no,
            'avg_price'             => $this->avg_price,
            'sale_price'            => $this->sale_price,
            'quantity'              => $this->quantity,
            'is_completed'          => $this->is_completed,
            'remaining_quantity'    => $this->remaining_quantity,
            'sale_id'               => $this->sale_id,
            'sale_invoice_no'       => $this->sale->sale_invoice_no,
            'sale_detail_id'        => $this->sale_detail_id,
            'location_id'           => $this->location_id,
            'location_name'         => $this->location->name,
            'inventory_id'          => $this->inventory_id,
            'inventory_item'        => $this->inventory->item->name,
            'created_at'            => date("d M Y, h:i A", strtotime($this->created_at)),  


        ];
    }
}
