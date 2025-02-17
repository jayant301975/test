<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class XmlFileRequest extends FormRequest
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
           'file' => ['required', 'mimes:xml'],
        ];
    }
	 public function messages()
    {
        return [
            'file.required' => "File Is Required, Please Upload Xml File",
			'file.mimes' => 'Invalid file type. Please upload a valid XML file.',
			'file.uploaded' => 'The file upload failed. Please try again.',
        ];
    }
}
