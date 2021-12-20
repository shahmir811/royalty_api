<?php

namespace App\Http\Resources;

use App\Http\Resources\PurchaseDetailResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
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
            'purchase_invoice_no' => $this->purchase_invoice_no,
            'local_purchase' => $this->local_purchase ? 'Yes' : 'No',
            'status' => $this->status->name,
            'total_amount' => number_format($this->total_amount,2),
            'user' => $this->user->name,
            'created_at' => date("d M Y, h:i A", strtotime($this->created_at)),
            'details' => PurchaseDetailResource::collection($this->purchases)
        ];
    }
}
