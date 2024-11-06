<?php

namespace App\Livewire\Forms;

use App\Rules\UniqueSerialNumber;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class QuarantineIntakeForm extends Form
{
    #[Validate(as: 'Opportunity or Project')]
    public int $object_id;

    public string $object_type;

    // public string $technical_supervisor;

    public string $serial_number_status = 'serial-number-exists';

    #[Validate]
    public string $serial_number;

    #[Validate(as: 'product')]
    public int $product_id;

    #[Validate(as: 'fault description')]
    public string $description;

    private int $type = 1; // Damaged

    private int $store = 1; // Head Office

    private int $stock_type = 1; // Rental

    private int $quantity_booked_in = 1;

    private bool $open_ended = true;

    public function rules(): array
    {
        return [
            // 'technical_supervisor' => [],
            'object_id' => ['required', 'numeric'],
            'object_type' => [
                'required',
                Rule::in(['project', 'opportunity']),
            ],
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

    public function store(): void
    {
        $validated = $this->validate();
        $reference = match ($this->serial_number_status) {
            'serial-number-exists' => $validated['serial_number'],
            'missing-serial-numbe' => 'Missing serial number',
            'not-serialised' => 'Equipment needs to be serialised',
        };

        Http::current()->dd()->post('quarantines', [
            'quarantine' => [
                'item_id' => $validated['product_id'],
                'store_id' => $this->store,
                'reference' => $reference,
                'description' => $validated['description'],
                'starts_at' => '',
                'quantity' => $this->quantity_booked_in,
                'quarantine_type' => $this->type,
                'open_ended' => $this->open_ended,
                'stock_type' => $this->stock_type,
            ],
        ]);

        dd('Success');
    }
}
