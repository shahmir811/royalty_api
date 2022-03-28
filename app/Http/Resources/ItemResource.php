<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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
            'id'            => $this->id,
            'name'          => $this->name,
            'package'       => $this->package,
            'cbm'           => number_format($this->cbm,2),
            'weight'        => number_format($this->weight,2),            
            'description'   => $this->description,
            'category_id'   => $this->category->id,
            'category'      => $this->category->name,
        ];
    }
}
