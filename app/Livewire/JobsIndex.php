<?php

namespace App\Livewire;

use App\Traits\WithHttpCurrentError;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Computed;
use Livewire\Component;

class JobsIndex extends Component
{
    use WithHttpCurrentError;

    #[Computed]
    public function jobs()
    {
        $response = Http::current()
            ->withQueryParameters([
                'per_page' => 25,
                'filtermode' => 'with_active_status',
            ])
            ->get('opportunities');

        if ($response->failed()) {
            return $this->errorMessage(__('An unexpected error occurred while fetching the Jobs list. Please refresh the page and try again.'), $response);
        }

        return $response->json()['opportunities'];
    }

    public function render(): View
    {
        return view('livewire.jobs-index');
    }
}
