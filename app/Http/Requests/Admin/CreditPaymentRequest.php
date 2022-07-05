<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreditPaymentRequest extends FormRequest
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
            'amount' => 'required|numeric',
            'reason' => 'required',  
            'paid_by' => 'required',                    
        ];
    }

    public function messages()
    {
        return [
            'amount.required' => 'Mention amount',
            'amount.numeric' => 'Kindly enter a valid amount',
            'reason.required' => 'Reason is required',
            'paid_by.required' => 'Mention name',
        ];
    }        
}
