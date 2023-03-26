<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MoveDetailResource extends JsonResource
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
            'quantity'          => $this->quantity,
            'inventory_id'      => $this->inventory_id,
            'item_name'         => $this->inventory->item->name,
            'created_at'        => date("d M Y, h:i A", strtotime($this->created_at)),            
        ];
    }
}
