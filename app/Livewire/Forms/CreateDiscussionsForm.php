<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateDiscussionsForm extends Form
{
    public int $opportunityId;

    public int $userId;

    public function store()
    {
        dd($this->opportunityId, $this->userId);
    }
}
