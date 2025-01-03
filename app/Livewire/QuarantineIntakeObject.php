<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class QuarantineIntakeObject extends Component
{
    public array $technicalSupervisors;

    public function render(): View
    {
        return view('livewire.quarantine-intake-object');
    }
}
