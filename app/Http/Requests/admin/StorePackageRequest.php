<?php

namespace App\Http\Requests\admin;

use App\Rules\EnumValue;
use App\Rules\NumericValue;
use Illuminate\Foundation\Http\FormRequest;

class StorePackageRequest extends FormRequest
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
           'title' => 'required|min:3',
           'description' => 'nullable|min:3',
           'price' => ['required',new NumericValue],
           'duration' => ['required',new NumericValue],
           'duration_unit' => ['required',new EnumValue],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The title field must be required',
            'title.min' => 'The title field must be at least :min characters long',
            'description.min' => 'The description field must be at least :min characters long',
            'price.required' => 'The price field must be required',
            'duration.required' => 'The duration field must be required',
            'duration_unit.required' => 'The duration_unit field must be required',
        ];


    }
}
