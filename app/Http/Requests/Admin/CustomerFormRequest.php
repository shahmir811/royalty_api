<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CustomerFormRequest extends FormRequest
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
            'name' => 'required',
            // 'mark' => 'required',
            'country' => 'required',
            'mobile_no_dubai' => 'required',
            'mobile_no_country' => 'required',
            // 'cargo_address' => 'sometimes|required',
            'credit_amount' => 'sometimes|numeric',                     
        ];
    }

    public function messages()
    {
        return [
            'mobile_no_dubai.required' => 'Dubai contact number is required',
            'mobile_no_country.required' => 'Country contact number is required',
        ];
    }              
}
