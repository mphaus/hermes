<?php

namespace App\Livewire\Forms;

use App\Rules\UniqueSerialNumber;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class QuarantineIntakeForm extends Form
{
    #[Validate(as: 'Opportunity or Project')]
    public string $project_or_opportunity;

    #[Validate(as: 'Technical Supervisor')]
    public int|null $technical_supervisor;

    public string $serial_number_status = 'serial-number-exists';

    #[Validate]
    public string $serial_number;

    #[Validate(as: 'product')]
    public int|null $product_id;

    #[Validate(as: 'fault description')]
    public string $description;

    private int $type = 1; // Damaged

    private int $store = 1; // Head Office

    // private int $stock_type = 1; // Rental

    private int $quantity_booked_in = 1;

    private bool $open_ended = true;

    public function clear(): void
    {
        $this->project_or_opportunity = '';
        $this->technical_supervisor = null;
        $this->serial_number_status = 'serial-number-exists';
        $this->serial_number = '';
        $this->product_id = null;
        $this->description = '';
    }

    public function rules(): array
    {
        return [
            'project_or_opportunity' => ['required'],
            'technical_supervisor' => ['required', 'numeric'],
            'serial_number_status' => [
                'required',
                Rule::in(['serial-number-exists', 'missing-serial-number', 'not-serialised']),
            ],
            'serial_number' => [
                Rule::requiredIf(fn() => $this->serial_number_status === 'serial-number-exists'),
                'max:256',
                'regex:/^[a-zA-Z0-9\/.-]+$/',
                new UniqueSerialNumber($this->serial_number_status),
            ],
            'product_id' => ['required', 'numeric'],
            'description' => ['required', 'max:512'],
        ];
    }

    public function store(): mixed
    {
        $validated = $this->validate();
        $reference = match ($this->serial_number_status) {
            'serial-number-exists' => $validated['serial_number'],
            'missing-serial-number' => 'Missing serial number',
            'not-serialised' => 'Equipment needs to be serialised',
        };

        $now = now('UTC');

        $response = Http::current()->post('quarantines', [
            'quarantine' => [
                'item_id' => App::environment(['local', 'staging']) ? intval(config('app.mph.test_product_id')) : intval($validated['product_id']),
                'store_id' => $this->store,
                'reference' => $reference,
                'description' => $validated['description'],
                'starts_at' => $now->format('Y-m-d\TH:i:s.\uZ'),
                'quantity' => $this->quantity_booked_in,
                'quarantine_type' => $this->type,
                'open_ended' => $this->open_ended,
                // 'stock_type' => $this->stock_type,
                'custom_fields' => [
                    'project_or_opportunity' => $validated['project_or_opportunity'],
                    'mph_technical_supervisor' => $validated['technical_supervisor'],
                ],
            ],
        ]);

        if ($response->failed()) {
            ['errors' => $errors] = $response->json();
            return $errors;
        }

        ['quarantine' => $quarantine] = $response->json();

        return $quarantine['id'];
    }
}
