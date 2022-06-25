<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'firstName' => 'required|string',
            'email' => 'required|email|unique:customers',
            'phone' => 'required',
            'lastName' => 'required|string',
            'password' => 'required'
        ];
    }


     /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'firstName.required' => 'First Name is Required',
            'lastName.required' => 'Last Name is Required',
            'phone.required' => 'Phone is Required',
            'email.required' => 'Email is required!',
            'email.unique' => 'This email is already used',
            'password.required' => 'Password is required!'
        ];
    }
}
