<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tax_percent'       => 'required',
            'contact_no'        => 'required',
            'shipping_location' => 'required',
            'customer_id'       => 'required|integer',
            'extra_charges'     => 'required',
            'payment_mode'      => 'required',
        ];
    }

    public function messages()
    {
        return [
            'tax_percent.required'          => 'Mention tax percentage',
            'extra_charges.required'        => 'Mention any extra charges',
            'customer_id.required'          => 'Select customer from dropdown',
            'contact_no.required'           => 'Contact no is required',
            'shipping_location.required'    => 'Shipping address is required',
            'payment_mode.required'         => 'Payment mode is required'
        ];
    }        

}
