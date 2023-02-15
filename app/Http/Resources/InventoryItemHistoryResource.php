<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InventoryItemHistoryResource extends JsonResource
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
            'description'           => $this->description,
            'status'                => $this->status,
            'purchase_price'        => number_format($this->purchase_price,2),
            'avg_price'             => number_format($this->avg_price,2),
            'sale_price'            => number_format($this->sale_price,2),   
            'quantity'              => number_format($this->quantity,2),      
            'purchased_invoice_no'  => $this->purchased_invoice_no,
            'sale_invoice_no'       => $this->sale_invoice_no,
            'action_performer'      => $this->action_performer,
            'inventory_id'          => $this->inventory_id,
            'created_at'            => date("d M Y, h:i A", strtotime($this->created_at)),
                                                      
        ];
    }
}
