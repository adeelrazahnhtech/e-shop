<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterSubAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name'  => 'required|min:3',
            'last_name'  => 'required|min:3',
            'email'      => 'required|email|unique:sub_admins|email',
            'password'   => ['required', Password::min(5)],
         ];
    }

    public function messages(): array
    {
        return [
         'first_name.required' => 'The first name must be required',
         'last_name.required' => 'The last name must be required',
          'email.required' => 'The email must be required' , 
          'password.required' => 'The password must be required' , 
        ];
    }

    public function attributes(): array
    {
        return [
         'first_name' => 'username',
         'last_name' => 'lastname',
          'email' => 'useremail' , 
        ];
    }
}
