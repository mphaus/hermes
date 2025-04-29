<?php

namespace App\View\Components;

use App\Traits\WithQuarantineIntakeClassification;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class QuarantineSelectPrimaryFaultClassification extends Component
{
    use WithQuarantineIntakeClassification;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.quarantine-select-primary-fault-classification');
    }
}
