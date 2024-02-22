<?php

namespace App\Livewire;

use App\Models\UploadLog;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

class UploadLogsShow extends Component
{
    #[Locked]
    public int $id;

    public function mount(int $id): void
    {
        $this->id = $id;
    }

    #[Computed]
    public function log(): UploadLog
    {
        return UploadLog::with('user')->findOrFail($this->id);
    }

    public function getJob(int $id): void
    {
        $response = Http::current()->get("opportunities/{$id}");
        $appName = config('app.name');
        $notFoundText = __('Failed loading log');

        if ($response->failed()) {
            $this->js("document.title = '{$notFoundText}'");
            $this->js("document.querySelector('[data-element=\"app-heading\"]').textContent = '{$notFoundText}'");
            return;
        }

        ['opportunity' => $opportunity] = $response->json();

        $this->js("document.title = '{$appName} - {$opportunity['subject']} - Log'");
        $this->js("document.querySelector('[data-element=\"app-heading\"]').textContent = '{$opportunity['subject']}'");
    }

    public function render(): View
    {
        return view('livewire.upload-logs-show');
    }
}
