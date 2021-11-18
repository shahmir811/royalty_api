<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserFormRequest extends FormRequest
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
            'role_id' => 'required|integer',
            'email' => "unique:users,email,$this->id,id",
            // 'password' => 'required|min:6',
            "password" => 'sometimes|nullable|min:6'
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'This email is already in use, use different one',
            'role_id.required' => 'Select role from dropdown',
            // 'token.exists' => 'It seems that entered referral ID is incorrect',
        ];
    }        
}
