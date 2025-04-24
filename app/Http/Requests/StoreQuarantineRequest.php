<?php

namespace App\Http\Requests;

use App\Rules\UniqueSerialNumber;
use App\Traits\WithQuarantineIntakeClassification;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class StoreQuarantineRequest extends FormRequest
{
    use WithQuarantineIntakeClassification;

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
            'opportunity_type' => [
                'required',
                Rule::in(['production-lighting-hire', 'dry-hire', 'not-associated']),
            ],
            'opportunity' => [Rule::requiredIf(fn() => request()->input('opportunity_type') !== 'not-associated')],
            'technical_supervisor_id' => [
                Rule::requiredIf(fn() => request()->input('opportunity_type') === 'production-lighting-hire'),
                function (string $attribute, mixed $value, Closure $fail) {
                    if (request()->input('opportunity_type') === 'production-lighting-hire' && !is_numeric($value)) {
                        $fail(__('The :attribute field must be a number.'));
                    }
                },
            ],
            'serial_number_status' => [
                'required',
                Rule::in(['serial-number-exists', 'missing-serial-number', 'not-serialised']),
            ],
            'serial_number' => [
                Rule::requiredIf(fn() => request()->input('serial_number_status') === 'serial-number-exists'),
                'max:256',
                'regex:/^[a-zA-Z0-9\/.\-\s]+$/',
                new UniqueSerialNumber(request()->input('serial_number_status')),
            ],
            'product_id' => ['required', 'numeric'],
            'starts_at' => ['required', 'date', function (string $attribute, mixed $value, Closure $fail) {
                $next_month_max_date = now('UTC')->addMonths(1)->endOfMonth()->format('Y-m-d');

                if (Carbon::parse($value)->greaterThan($next_month_max_date)) {
                    $fail(__('The :attribute field must not be a greater date than the last day of the next month.'));
                }
            }],
            'intake_location' => [
                Rule::requiredIf(fn() => request()->input('starts_at') === now()->format('Y-m-d') && request()->input('intake_location_type') === 'on-a-shelf'),
                function (string $attribute, mixed $value, Closure $fail) {
                    if (request()->input('starts_at') !== now()->format('Y-m-d')) {
                        return;
                    }

                    if (!preg_match('/^[A-Ia-i]-(?:[1-9]|[1-4][0-9]|5[0-5])$/', $value)) {
                        $fail(__('The :attribute field format is invalid. Accepted letters from A to I. Accepted numbers from 1 to 55.'));
                    }
                }
            ],
            'classification' => [
                'required',
                Rule::in($this->getClassificationTexts()),
            ],
            'description' => ['required', 'max:512'],
        ];
    }

    public function attributes(): array
    {
        return [
            'opportunity_type' => __('opportunity type'),
            'opportunity' => __('opportunity'),
            'technical_supervisor_id' => __('technical supervisor'),
            'product_id' => __('product'),
            'starts_at' => __('ready for repairs'),
            'classification' => __('primary fault classification'),
            'description' => __('fault description'),
        ];
    }
}
