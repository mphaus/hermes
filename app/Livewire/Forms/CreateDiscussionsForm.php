<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateDiscussionsForm extends Form
{
    #[Validate('required|numeric', as: 'opportunity')]
    public int $opportunityId;

    #[Validate('required|numeric', as: 'owner')]
    public int $userId;

    public function store()
    {
        $this->validate();
        dd($this->opportunityId, $this->userId);
    }
}
