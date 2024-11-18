<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class TechnicalSupervisorForm extends Form
{
    #[Validate('required', as: 'first name')]
    public string $first_name;

    #[Validate('required', as: 'last name')]
    public string $last_name;

    public function store()
    {
        $validated = $this->validate();

        dd('Success');
    }
}
