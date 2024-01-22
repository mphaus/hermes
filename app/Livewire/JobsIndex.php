<?php

namespace App\Livewire;

use JJSoftwareLtd\CurrentGateway\Facades\CurrentGateway;
use Livewire\Attributes\Computed;
use Livewire\Component;

class JobsIndex extends Component
{
    #[Computed]
    public function jobs()
    {
        $req = CurrentGateway::get('opportunities', [
            'per_page' => 25,
            'filtermode' => 'with_active_status',
        ]);

        return collect($req['opportunities']);
    }

    public function render()
    {
        return view('livewire.jobs-index');
    }
}
