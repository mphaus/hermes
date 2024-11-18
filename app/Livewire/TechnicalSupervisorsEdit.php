<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class TechnicalSupervisorsEdit extends Component
{
    public function mount()
    {
        sleep(5);
    }

    public function placeholder(): View
    {
        return view('technical-supervisors-edit-skeleton');
    }

    public function render(): View
    {
        return view('livewire.technical-supervisors-edit');
    }
}
