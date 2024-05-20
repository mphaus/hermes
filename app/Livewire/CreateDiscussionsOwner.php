<?php

namespace App\Livewire;

use App\Traits\WithHttpCurrentError;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CreateDiscussionsOwner extends Component
{
    use WithHttpCurrentError;

    #[Computed]
    public function members(): array
    {
        $defaultResponse = [
            'error' => '',
            'data' => [],
        ];

        $response = Http::current()
            ->withQueryParameters([
                'per_page' => 25,
                'filtermode' => 'user',
                'q[active_eq]' => true,
            ])
            ->get('members');

        if ($response->failed()) {
            return [
                ...$defaultResponse,
                'error' => $this->errorMessage(__('An unexpected error occurred while fetching Users. Please refresh the page and try again.'), $response->json()),
            ];
        }

        ['members' => $members] = $response->json();

        if (empty($members)) {
            return $defaultResponse;
        }

        return [
            ...$defaultResponse,
            'data' => $members,
        ];
    }

    public function placeholder(): View
    {
        return view('create-discussions-skeleton');
    }

    public function render(): View
    {
        return view('livewire.create-discussions-owner');
    }
}
