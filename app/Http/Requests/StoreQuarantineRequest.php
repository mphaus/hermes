<?php

namespace App\Http\Requests;

use App\Facades\CurrentRMS;
use App\Mail\QuarantineCreated;
use App\Rules\UniqueSerialNumber;
use App\Traits\WithQuarantineFaultClassification;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class StoreQuarantineRequest extends FormRequest
{
    use WithQuarantineFaultClassification;

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
                'nullable',
                function (string $attribute, mixed $value, Closure $fail) {
                    if (request()->input('opportunity_type') === 'production-lighting-hire' && !is_numeric($value)) {
                        $fail('The :attribute field must be a number.');
                    }
                },
            ],
            'product_id' => ['required', 'numeric'],
            'owner_id' => ['required', 'numeric'],
            'serial_number_status' => [
                'required',
                Rule::in(['serial-number-exists', 'missing-serial-number', 'not-serialised']),
            ],
            'serial_number' => [
                Rule::requiredIf(fn() => request()->input('serial_number_status') === 'serial-number-exists'),
                'nullable',
                'max:256',
                'regex:/^[a-zA-Z0-9\/.\-\s]+$/',
                new UniqueSerialNumber(request()->input('serial_number_status')),
            ],
            'starts_at' => ['required', 'date', function (string $attribute, mixed $value, Closure $fail) {
                $next_month_max_date = now('UTC')->addMonths(1)->endOfMonth()->format('Y-m-d');

                if (Carbon::parse($value)->greaterThan($next_month_max_date)) {
                    $fail('The :attribute field must not be a greater date than the last day of the next month.');
                }
            }],
            'intake_location_type' => [
                'nullable',
                Rule::in(['on-a-shelf', 'in-the-bulky-products-area']),
            ],
            'intake_location' => [
                Rule::requiredIf(fn() => request()->input('starts_at') === now()->format('Y-m-d') && request()->input('intake_location_type') === 'on-a-shelf'),
                'nullable',
                function (string $attribute, mixed $value, Closure $fail) {
                    if (request()->input('starts_at') !== now()->format('Y-m-d')) {
                        return;
                    }

                    if (!preg_match('/^[A-Ia-i]-(?:[1-9]|[1-4][0-9]|5[0-5])$/', $value)) {
                        $fail('The :attribute field format is invalid. Accepted letters from A to I. Accepted numbers from 1 to 55.');
                    }
                }
            ],
            'classification' => [
                'required',
                Rule::in($this->getFaultClassificationValues()),
            ],
            'description' => ['required', 'max:512'],
        ];
    }

    public function attributes(): array
    {
        return [
            'opportunity_type' => 'opportunity type',
            'opportunity' => 'opportunity',
            'technical_supervisor_id' => 'technical supervisor',
            'product_id' => 'product',
            'owner_id' => 'owner',
            'starts_at' => 'ready for repairs',
            'classification' => 'primary fault classification',
            'description' => 'fault description',
        ];
    }

    public function store(): array
    {
        $validated = $this->validated();

        [
            'opportunity_type' => $opportunity_type,
            'opportunity' => $opportunity,
            'technical_supervisor_id' => $technical_supervisor_id,
            'serial_number_status' => $serial_number_status,
            'serial_number' => $serial_number,
            'product_id' => $product_id,
            'owner_id' => $owner_id,
            'starts_at' => $starts_at,
            'intake_location_type' => $intake_location_type,
            'intake_location' => $intake_location,
            'classification' => $classification,
            'description' => $description,
        ] = $validated;

        $reference = match ($serial_number_status) {
            'serial-number-exists' => $serial_number,
            'missing-serial-number' => 'Missing serial number',
            'not-serialised' => 'Equipment needs to be serialised',
        };

        $starts_at = now()->parse($starts_at);
        $is_same_day = $starts_at->isSameDay(now());
        $starts_at_text = $is_same_day
            ? 'Item is in on Quarantine Intake shelving and is available for repairs work right now.'
            : "Item expected to be back in the warehouse and available for repairs work on {$starts_at->format('D d-M-Y')}.";

        $first_name = Auth::user()->first_name;
        $description = '"' .
            $description .
            '"' .
            PHP_EOL .
            PHP_EOL .
            $starts_at_text .
            PHP_EOL .
            PHP_EOL .
            'Primary fault classification type ' .
            ':' .
            $classification .
            ':' .
            PHP_EOL .
            PHP_EOL .
            "Submitted by {$first_name}";

        $result = CurrentRMS::store(uri: 'quarantines', data: [
            'quarantine' => [
                'item_id' => intval($product_id),
                'store_id' => 1,
                'owned_by' => $owner_id,
                'reference' => $reference,
                'description' => $description,
                'starts_at' => $starts_at->setTime(12, 0, 0, 0)->setTimezone('UTC')->format('Y-m-d\TH:i:s'),
                'quantity' => 1,
                'quarantine_type' => 1, // Damaged
                'open_ended' => true,
                // 'stock_type' => 1, // Rental
                'custom_fields' => [
                    'opportunity' => $opportunity_type !== 'not-associated' ? $opportunity : 'Not associated with any Job',
                    'mph_technical_supervisor' => $technical_supervisor_id,
                    'intake_location' => $intake_location_type === 'in-the-bulky-products-area'
                        ? 'Bulky Products area'
                        : ($is_same_day
                            ? mb_strtoupper($intake_location)
                            : 'NtYtAvail'),
                ],
            ],
        ]);

        if ($result['fail']) {
            ['fail' => ['data' => $errorData]] = $result;

            return [
                'error' => $errorData,
                'data' => [],
            ];
        }

        ['quarantine' => $quarantine] = $result['data'];

        return [
            'error' => '',
            'data' => [
                ...$quarantine,
                'primary_fault_classification' => $classification,
                'ready_for_repairs' => $is_same_day ? 'Now' : $starts_at->setTime(12, 0, 0, 0)->setTimezone('UTC')->format('Y-m-d\TH:i:s'),
            ],
        ];
    }
}
