<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateDeliveryNoteRequest extends FormRequest
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
            'contact_no'        => 'required',
            'shipping_location' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'contact_no.required'           => 'Contact no is required',
            'shipping_location.required'    => 'Shipping address is required'
        ];
    }      
}
