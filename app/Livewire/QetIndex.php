<?php

namespace App\Livewire;

use App\Facades\QET;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

class QetIndex extends Component
{
    #[Locked]
    public string $date = '';

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    #[Computed]
    public function qet(): array
    {
        $defaultResponse = [
            'error' => '',
            'items' => collect([]),
        ];

        if (empty($this->date)) {
            return $defaultResponse;
        }

        $qet = QET::get($this->date);

        return [
            ...$defaultResponse,
            'items' => collect($qet),
        ];
    }

    public function render(): View
    {
        return view('livewire.qet-index');
    }
}
