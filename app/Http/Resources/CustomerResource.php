<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'name' => $this->name,
            'mark' => $this->mark,
            'country' => $this->country,
            'mobile_no_dubai' => $this->mobile_no_dubai,
            'mobile_no_country' => $this->mobile_no_country,
            'cargo_address' => $this->cargo_address,
            'credit_amount' => number_format($this->credits->sum('due_amount'), 2),
            'status' => $this->deleted_at ? 'Deactive' : 'Active',
        ];
    }
}
