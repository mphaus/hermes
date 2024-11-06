<?php

namespace App\Livewire\Forms;

use App\Rules\UniqueSerialNumber;
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
        $this->validate();

        dd('Success');
    }
}
