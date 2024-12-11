<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;

class QuarantineStatsIndex extends Component
{
    #[Url]
    public array $products = [];

    public function setFilter(array $filter)
    {
        [
            'products' => $products,
        ] = $filter;

        $this->products = $products;
    }

    public function render(): View
    {
        return view('livewire.quarantine-stats-index');
    }
}
