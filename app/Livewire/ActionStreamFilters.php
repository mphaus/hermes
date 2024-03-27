<?php

namespace App\Livewire;

use App\Traits\WithActionType;
use App\Traits\WithMember;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ActionStreamFilters extends Component
{
    use WithActionType;
    use WithMember;

    #[Computed]
    public function actionTypes(): array
    {
        return $this->getActionTypes();
    }

    #[Computed]
    public function members(): array
    {
        return $this->getMembers();
    }

    public function render(): View
    {
        return view('livewire.action-stream-filters');
    }
}
