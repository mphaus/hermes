<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEquipmentImportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return usercan('access-equipment-import');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'opportunity_id' => ['required', 'numeric'],
            'csv_file' => ['required', 'file', 'max:512', 'mimes:csv'],
        ];
    }

    public function messages(): array
    {
        return [
            'csv_file.file' => __('This field must be a file.'),
            'csv_file.max' => __('The :attribute field must not be greater than :max kilobytes.'),
            'csv_file.mimes' => __('The file must be a file of type: :values.'),
        ];
    }
}
