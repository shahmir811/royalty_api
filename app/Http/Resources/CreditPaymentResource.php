<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CreditPaymentResource extends JsonResource
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
            'transaction_id'    => $this->transaction_id,
            'amount'            => number_format($this->amount, 2),
            'user_id'           => $this->user_id,
            'received_by'       => $this->user->name,
            'received_date'     => date("d M Y, h:i A", strtotime($this->created_at)),
        ];
    }
}
