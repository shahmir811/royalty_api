<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleDetailResource extends JsonResource
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
            'avg_price'         => number_format($this->avg_price,2),
            'sale_price'        => number_format($this->sale_price,2),
            'quantity'          => $this->quantity,
            'total_avg_price'   => number_format($this->total_avg_price,2),
            'total_sale_price'  => number_format($this->total_sale_price,2),
            // 'total_price'       => number_format($this->total_sale_price,2),
            'total_price'       => $this->total_sale_price,
            'location'          => $this->location->name,
            'location_id'       => $this->location_id,
            'inventory'         => $this->inventory->item->name,
            'name'              => $this->inventory->item->name,
            'inventory_id'      => $this->inventory_id,            

        ];
    }
}
