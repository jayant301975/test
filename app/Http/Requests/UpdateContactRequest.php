<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
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
             'name' => 'required|string',
            'country_code' => 'required|string',
            'mobile' => 'required|numeric',
        ];
    }
	public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'country_code.required' => 'Country code is required.',
            'mobile.required' => 'The mobile number is required.',
            'mobile.numeric' => 'The mobile number must be a valid number.',
        ];
    }
}
