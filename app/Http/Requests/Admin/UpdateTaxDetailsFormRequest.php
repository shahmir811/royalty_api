<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaxDetailsFormRequest extends FormRequest
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
            'percent' => 'required|integer',
            'show_tax' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'percent.required' => 'Mention tax percentage amount',
        ];
    }        

}
