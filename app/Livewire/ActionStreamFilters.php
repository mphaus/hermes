<?php

namespace App\Livewire;

use App\Traits\WithActionType;
use App\Traits\WithMember;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ActionStreamFilters extends Component
{
    use WithActionType;
    use WithMember;

    #[Locked]
    public array $memberIds = [];

    #[Locked]
    public array $_actionTypes = [];

    #[Locked]
    public array $dateRange = [];

    #[Locked]
    public array $formattedDateRange = [];

    public function mount(array $memberIds, array $actionTypes, array $dateRange)
    {
        $this->memberIds = $memberIds;
        $this->_actionTypes = $actionTypes;
        $this->dateRange = $dateRange;

        if ($this->dateRange) {
            $this->formattedDateRange = array_map(fn ($date) => date('d-M-Y', strtotime($date)), $this->dateRange);
        }
    }

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
