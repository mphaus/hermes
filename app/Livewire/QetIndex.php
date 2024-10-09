<?php

namespace App\Livewire;

use App\Facades\QET;
use App\Traits\WithHttpCurrentError;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

class QetIndex extends Component
{
    use WithHttpCurrentError;

    #[Locked]
    public string $date = '';

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function getQet(): array
    {
        $defaultResponse = [
            'error' => '',
            'groups' => collect([]),
        ];

        if (empty($this->date)) {
            return $defaultResponse;
        }

        $qet = QET::get($this->date);

        if ($qet instanceof \GuzzleHttp\Exception\ClientException) {
            return [
                ...$defaultResponse,
                'error' => $this->errorMessage(__('An unexpected error occurred while fetching the QET list. Please refresh the page and try again.'), json_decode($qet->getResponse()->getBody(), true)),
            ];
        }

        if (empty($qet)) {
            return $defaultResponse;
        }

        return [
            ...$defaultResponse,
            'groups' => collect($qet),
        ];
    }

    public function render(): View
    {
        return view('livewire.qet-index', [
            'qet' => $this->getQet(),
        ]);
    }
}
