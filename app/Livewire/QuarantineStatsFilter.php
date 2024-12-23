<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class QuarantineStatsFilter extends Component
{
    public function render(): View
    {
        return view('livewire.quarantine-stats-filter');
    }
}
