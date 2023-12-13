<?php

namespace App\Http\Requests;

use App\Rules\Lowercase;
use App\Rules\NumericValue;
use Illuminate\Foundation\Http\FormRequest;

class StoreAdminProductRequest extends FormRequest
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
            'title' => ['required','min:3'],
            'description' => ['nullable',new Lowercase],
            'price' => ['required',new NumericValue],
            'track_qty' => ['required',new NumericValue],
            'status'    => 'required',
            'category' => 'required',
        ];
    }


    public function messages(): array
    {
        return [
          'title.required' => 'The title field must be required',
          'title.min' => 'The title field must be at least :min characters long',
        ];
    }
}
