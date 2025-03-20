<?php

namespace App\Livewire\Forms;

use App\Mail\QuarantineCreated;
use App\Rules\UniqueSerialNumber;
use App\Traits\WithQuarantineIntakeClassification;
use Closure;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class QuarantineIntakeForm extends Form
{
    use WithQuarantineIntakeClassification;

    #[Validate(as: 'Opportunity type')]
    public string $opportunity_type = 'production-lighting-hire';

    #[Validate(as: 'Opportunity')]
    public string $opportunity;

    #[Validate(as: 'Technical Supervisor')]
    public int|null $technical_supervisor;

    public string $serial_number_status = 'serial-number-exists';

    #[Validate]
    public string $serial_number;

    #[Validate(as: 'product')]
    public int|null $product_id;

    #[Validate(as: 'ready for repairs')]
    public string $starts_at;

    public string $intake_location_type = 'on-a-shelf';

    #[Validate(as: 'intake location')]
    public string $intake_location;

    #[Validate(as: 'primary fault classification')]
    public string $classification;

    #[Validate(as: 'fault description')]
    public string $description;

    private int $type = 1; // Damaged

    private int $store = 1; // Head Office

    // private int $stock_type = 1; // Rental

    private int $quantity_booked_in = 1;

    private bool $open_ended = true;

    protected function rules(): array
    {
        return [
            'opportunity_type' => [
                'required',
                Rule::in(['production-lighting-hire', 'dry-hire', 'not-associated']),
            ],
            'opportunity' => [Rule::requiredIf(fn() => $this->opportunity_type !== 'not-associated')],
            'technical_supervisor' => [
                Rule::requiredIf(fn() => $this->opportunity_type === 'production-lighting-hire'),
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->opportunity_type === 'production-lighting-hire' && !is_numeric($value)) {
                        $fail(__('The :attribute field must be a number.'));
                    }
                },
            ],
            'serial_number_status' => [
                'required',
                Rule::in(['serial-number-exists', 'missing-serial-number', 'not-serialised']),
            ],
            'serial_number' => [
                Rule::requiredIf(fn() => $this->serial_number_status === 'serial-number-exists'),
                'max:256',
                'regex:/^[a-zA-Z0-9\/.\-\s]+$/',
                new UniqueSerialNumber($this->serial_number_status),
            ],
            'product_id' => ['required', 'numeric'],
            'starts_at' => ['required', 'date', function (string $attribute, mixed $value, Closure $fail) {
                $next_month_max_date = now('UTC')->addMonths(1)->endOfMonth()->format('Y-m-d');

                if (Carbon::parse($value)->greaterThan($next_month_max_date)) {
                    $fail(__('The :attribute field must not be a greater date than the last day of the next month.'));
                }
            }],
            'intake_location' => [
                Rule::requiredIf(fn() => $this->starts_at === now()->format('Y-m-d') && $this->intake_location_type === 'on-a-shelf'),
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->starts_at !== now()->format('Y-m-d')) {
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

    public function store(): array
    {
        $validated = $this->validate();
        $reference = match ($this->serial_number_status) {
            'serial-number-exists' => $validated['serial_number'],
            'missing-serial-number' => 'Missing serial number',
            'not-serialised' => 'Equipment needs to be serialised',
        };

        $starts_at = now()->parse($validated['starts_at']);
        $is_same_day = $starts_at->isSameDay(now());
        $starts_at_text = $is_same_day
            ? __('Item is in on Quarantine Intake shelving and is available for repairs work right now.')
            : __('Item expected to be back in the warehouse and available for repairs work on :date.', ['date' => $starts_at->format('D d-M-Y')]);

        $description = '"' .
            $validated['description'] .
            '"' .
            PHP_EOL .
            PHP_EOL .
            $starts_at_text .
            PHP_EOL .
            PHP_EOL .
            'Primary fault classification type ' .
            ':' .
            $validated['classification'] .
            ':' .
            PHP_EOL .
            PHP_EOL .
            __('Submitted by :first_name', ['first_name' => Auth::user()->first_name]);

        $response = Http::current()->post('quarantines', [
            'quarantine' => [
                'item_id' => App::environment(['local', 'staging']) ? intval(config('app.mph.test_product_id')) : intval($validated['product_id']),
                'store_id' => $this->store,
                'reference' => $reference,
                'description' => $description,
                'starts_at' => $starts_at->setTime(12, 0, 0, 0)->setTimezone('UTC')->format('Y-m-d\TH:i:s'),
                'quantity' => $this->quantity_booked_in,
                'quarantine_type' => $this->type,
                'open_ended' => $this->open_ended,
                // 'stock_type' => $this->stock_type,
                'custom_fields' => [
                    'opportunity' => $validated['opportunity_type'] !== 'not-associated' ? $validated['opportunity'] : __('Not associated with any Job'),
                    'mph_technical_supervisor' => $validated['technical_supervisor'],
                    'intake_location' => $this->intake_location_type === 'in-the-bulky-products-area'
                        ? __('Bulky Products area')
                        : ($is_same_day
                            ? mb_strtoupper($validated['intake_location'])
                            : __('TBC')),
                ],
            ],
        ]);

        if ($response->failed()) {
            ['errors' => $errors] = $response->json();

            return [
                'type' => 'success',
                'errors' => $errors,
                'data' => [],
            ];
        }

        ['quarantine' => $quarantine] = $response->json();

        Mail::to(['garion@mphaus.com', 'service.manager@mphaus.com'])->send(new QuarantineCreated($quarantine, $validated['classification'], $description, Auth::user()));

        return [
            'type' => 'success',
            'errors' => [],
            'data' => [
                ...$quarantine,
                'primary_fault_classification' => $validated['classification'],
                'ready_for_repairs' => $is_same_day ? __('Now') : $starts_at->setTime(12, 0, 0, 0)->setTimezone('UTC')->format('Y-m-d\TH:i:s'),
            ],
        ];
    }
}
