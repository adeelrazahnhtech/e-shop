<?php

namespace App\Http\Requests;

use App\Rules\MinCharacter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterUserRequest extends FormRequest
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
            'first_name'  => ['required',new MinCharacter(3)],
            'last_name'  => ['required',new MinCharacter(3)],
            'email'      => 'required|email|unique:users',
            'password'   => ['required','confirmed', Password::min(5)],
            'role'      => 'required',
         ];
    }

    public function messages(): array
    {
        return [
          'first_name.required' => 'The first name field must be required',
          'last_name.required' => 'The last name field must be required',
          'email.required' => 'The email field must be required' , 
          'email.email' => 'Please enter a valid email', 
          'email.unique' => 'This email is already in use',
          'password.required' => 'The password field must be required',
          'password.confirmed' => 'The password confirmation does not match',
          'password.min' => 'The password must be at least :min characters long',  
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
