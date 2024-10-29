<?php

namespace App\Livewire;

use App\Livewire\Forms\QuarantineIntakeForm;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class QuarantineIntakeCreate extends Component
{
    public QuarantineIntakeForm $form;

    public function save(): void
    {
        dd($this->form);
    }

    public function render(): View
    {
        return view('livewire.quarantine-intake-create');
    }
}
