<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseDetailResource extends JsonResource
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
            'price' => number_format($this->price,2),
            'quantity' => $this->quantity,
            'total_price' => number_format($this->total_price,2),
            'location_name' => $this->location->name,
            'item_name' => $this->inventory->item_name,
        ];
    }
}
