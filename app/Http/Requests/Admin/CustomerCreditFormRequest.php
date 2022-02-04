<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CustomerCreditFormRequest extends FormRequest
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
            'sale_id'           => 'required|integer',
            'due_amount'        => 'required|numeric',
            'total_amount_paid' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'sale_id.required'           => 'Select sales record from dropdown',
            'due_amount.required'        => 'Mention the remaining amount',
            'total_amount_paid.required' => 'Mention the total amount',
        ];
    }           
}
