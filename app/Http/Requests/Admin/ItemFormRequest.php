<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ItemFormRequest extends FormRequest
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
            'name'          => 'required',
            'package'       => 'required',
            'cbm'           => 'required|numeric',
            'weight'        => 'required|numeric', 
            'category_id'   => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Mention item name',
            'category_id.required'   => 'Select category from dropdown'
        ];
    }   

}
