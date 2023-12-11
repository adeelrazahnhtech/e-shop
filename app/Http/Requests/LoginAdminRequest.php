<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginAdminRequest extends FormRequest
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
           'email' => 'required|email',
           'password' => 'required'
        ];
    }


    public function messages(): array 
    {
        return [
          'email.required' => 'The email must be required',
          'password.required' => 'The password must be required',

        ];
    }

    public function attributes() 
    {
        return  [
         'email' => 'username',
         'password' => 'userpassword',
        ];
    }
}
