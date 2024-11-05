<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class QuarantineIntakeForm extends Form
{
    public int $object_id;

    public string $object_type;

    public string $serial_number_status = 'serial-number-exists';

    #[Validate]
    public string $serial_number;

    public int $product_id;

    public string $description;

    private int $type = 1; // Damaged

    private int $store = 1; // Head Office

    private int $stock_type = 1; // Rental

    private int $quantity_booked_in = 1;

    private bool $open_ended = true;

    public function rules(): array
    {
        return [];
    }

    public function store() {}
}
