<?php

namespace App\Livewire;

use App\Facades\QET;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Url;
use Livewire\Component;

class QetIndex extends Component
{
    #[Url]
    public string $date = '';

    #[Locked]
    public array $qet = [];

    public function fetchQET($selectedDate)
    {
        $this->date = $selectedDate;

        $defaultResponse = [
            'error' => '',
            'items' => collect([]),
        ];

        if (!$selectedDate) {
            $this->qet = $defaultResponse;
            return;
        }

        dd(QET::get($this->date));
    }

    public function render(): View
    {
        return view('livewire.qet-index');
    }
}
