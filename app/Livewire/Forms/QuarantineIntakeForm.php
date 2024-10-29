<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class QuarantineIntakeForm extends Form
{
    public int $object_id;

    public string $serial_number_status = 'serial-number-exists';

    public string $serial_number;

    public int $product_id;

    public string $description;
}
