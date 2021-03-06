<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class InventoryFormRequest extends FormRequest
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
            // 'item_name' => 'required',
            // 'package' => 'required',
            // 'cbm' => 'required|numeric',
            // 'weight' => 'required|numeric',    
            'quantity' => 'required|integer',
            'purchase_price' => 'required|numeric',
            'avg_price' => 'required|numeric',    
            'sale_price' => 'required|numeric',   
            'item_id' => 'required|integer', 
            'location_id' => 'required|integer', 
        ];
    }

    public function messages()
    {
        return [
            // 'item_name.required' => 'Mention item name',
            'item_id.required' => 'Select item from dropdown',
            'location_id.required' => 'Select location from dropdown',
            'purchase_price.required' => 'Item purchase price is required',
            'avg_price.required' => 'Item average price is required',
            'sale_price.required' => 'Item sale price is required',
        ];
    }          
}
