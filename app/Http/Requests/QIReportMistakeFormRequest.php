<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QIReportMistakeFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return usercan('access-quarantine-intake');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'submitted' => 'required',
            'quarantine_id' => 'required',
            'job' => 'required',
            'product' => 'required',
            'serial' => 'required',
            'ready_for_repairs' => 'required',
            'primary_fault_classification' => 'required',
            'fault_description' => 'required',
            'intake_location' => 'required',
            'message' => 'required',
        ];
    }
}
