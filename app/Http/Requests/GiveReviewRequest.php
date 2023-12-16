<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GiveReviewRequest extends FormRequest
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
            'rating' => 'required',
            'review' => 'required|min:3',
            'product_id' => 'required',
            'status' => 'nullable',
            'reviewable_id' => 'nullable',
            'reviewable_type' => 'nullable',

        ];
    }


    public function messages(): array 
    {
        return [
          'rating.required' => 'The rating field must be required',
          'review.required' => 'The review field must be required',
          'review.min' => 'The review field must be at least :min character long',

        ];
    }
}
