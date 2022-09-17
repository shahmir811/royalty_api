<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryNoteDetailsResource extends JsonResource
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
            'delivery_note_id'      => $this->delivery_note->id,
            'delivery_note_no'  => $this->delivery_note->delivery_note_no,
            'quantity'              => $this->quantity,
            'location_id'           => $this->location_id,
            'location_name'         => $this->location->name,
            'inventory_id'          => $this->inventory_id,
            'inventory_item'        => $this->inventory->item->name,
            'created_at'            => date("d M Y, h:i A", strtotime($this->created_at)),  


        ];
    }
}
