<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
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
            'id' => $this->id,
            // 'item_name' => $this->item_name,
            'quantity' => $this->quantity,
            // 'description' => $this->description,
            // 'package' => $this->package,
            // 'cbm' => number_format($this->cbm,2),
            // 'weight' => number_format($this->weight,2),
            'purchase_price' => number_format($this->purchase_price,2),
            'sale_price' => number_format($this->sale_price,2),
            'avg_price' => number_format($this->avg_price,2),
            'location_id' => $this->location->id,
            'location' => $this->location->name,
            'status' => $this->deleted_at ? 'Deactive' : 'Active',
        ];
    }
}
