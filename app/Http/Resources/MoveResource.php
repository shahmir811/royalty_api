<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MoveResource extends JsonResource
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
            'from_location_id'  => $this->from_location_id,
            'to_location_id'    => $this->to_location_id,
            'from_location'     => $this->from_location->name,
            'to_location'       => $this->to_location->name,
            'move_invoice_no'   => $this->move_invoice_no,
            'created_by'        => $this->user->name,
            'created_at'        => date("d M Y, h:i A", strtotime($this->created_at)),
            'details'           => MoveDetailResource::collection($this->move_details)

        ];
    }
}
