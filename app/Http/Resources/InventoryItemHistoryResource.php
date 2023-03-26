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
            'quantity'              => number_format($this->quantity,2),
            'purchase_id'           => $this->purchase_id,      
            'purchased_invoice_no'  => $this->purchased_invoice_no,
            'sale_id'               => $this->sale_id,      
            'sale_invoice_no'       => $this->sale_invoice_no,
            'move_id'               => $this->move_id,      
            'move_invoice_no'       => $this->move_invoice_no,            
            'action_performer'      => $this->action_performer,
            'inventory_id'          => $this->inventory_id,
            'created_at'            => date("d M Y, h:i A", strtotime($this->created_at)),
                                                      
        ];
    }
}
