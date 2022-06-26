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
            'item_id' => $this->item_id,
            'item_name' => $this->item->name,
            'quantity' => $this->quantity,
            // 'description' => $this->description,
            // 'package' => $this->package,
            'package' => number_format($this->quantity / $this->item->package,2) ,
            // 'cbm' => number_format($this->cbm,2),
            // 'weight' => number_format($this->weight,2),
            'purchase_price' => number_format($this->purchase_price,2),
            'sale_price' => number_format($this->sale_price,2),
            'avg_price' => number_format($this->avg_price,2),
            'location_id' => $this->location->id,
            'location' => $this->location->name,
            'categories' => $this->item->category->name,
            'status' => $this->deleted_at ? 'Deactive' : 'Active',
            'total_cost_value' => number_format($this->avg_price * $this->quantity, 2)
        ];
    }
}
