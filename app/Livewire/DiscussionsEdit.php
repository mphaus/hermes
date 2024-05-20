<?php

namespace App\Livewire;

use App\Models\DiscussionMapping;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class DiscussionsEdit extends Component
{
    public function downloadJsonConfig()
    {
        /** @var DiscussionMapping */
        $config = DiscussionMapping::latest()->first();

        if ($config === null) {
            session()->flash('alert', [
                'type' => 'warning',
                'message' => __('There is currently no default configuration for Discussions. Upload a JSON file to set a new one.'),
            ]);

            return $this->redirectRoute(name: 'discussions.edit', navigate: true);
        }

        $createdAt = now()->parse($config->created_at)->timezone(config('app.timezone'))->format('Y-m-d-H-i-s');
        $filename = "discussions-config-{$createdAt}.json";

        Storage::disk('local')->put(
            path: $filename,
            contents: json_encode($config->mappings->jsonSerialize(), JSON_PRETTY_PRINT)
        );

        return Storage::download(
            path: $filename,
            name: $filename,
            headers: ['Content-Type' => 'application/json']
        );
    }

    public function render(): View
    {
        return view('livewire.discussions-edit');
    }
}
