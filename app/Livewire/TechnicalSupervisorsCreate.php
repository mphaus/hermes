<?php

namespace App\Livewire;

use App\Livewire\Forms\TechnicalSupervisorForm;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class TechnicalSupervisorsCreate extends Component
{
    public TechnicalSupervisorForm $form;

    public function save()
    {
        $this->form->store();
    }

    public function render(): View
    {
        return view('livewire.technical-supervisors-create');
    }
}
