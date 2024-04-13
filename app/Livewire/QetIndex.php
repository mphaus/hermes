<?php

namespace App\Livewire;

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

        $startDate = Carbon::createFromFormat('Y-m-d', $this->date);
        $endDate = Carbon::createFromFormat('Y-m-d', $this->date);

        $startDate->setTime(0, 0, 0, 0)->setTimezone('UTC');
        $endDate->setTime(0, 0, 0, 0)->setTimezone('UTC')->addDay();

        $response = Http::current()
            ->withQueryParameters([
                'per_page' => 25,
                'q[unload_starts_at_gteq]' => $startDate->format('Y-m-d'),
                'q[unload_ends_at_lteq]' => $endDate->format('Y-m-d'),
                'q[load_starts_at_gteq]' => $startDate->format('Y-m-d'),
                'q[load_ends_at_lteq]' => $endDate->format('Y-m-d'),
                'include[]' => 'opportunity_items',
            ])
            ->get('opportunities');

        if ($response->failed()) {
            // HANDLE ERROR HERE
        }

        dd($response->json());
    }

    public function render(): View
    {
        return view('livewire.qet-index');
    }
}
