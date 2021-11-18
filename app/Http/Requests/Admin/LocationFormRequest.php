<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LocationFormRequest extends FormRequest
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
            'contact_no' => 'required',                  
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Mention location name',
            'contact_no.required' => 'Contact number is required',
        ];
    }      
}
