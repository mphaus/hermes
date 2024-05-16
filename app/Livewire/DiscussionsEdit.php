<?php

namespace App\Livewire;

use App\Models\DiscussionMapping;
use Illuminate\Contracts\Cache\Store;
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
        $filename = "Discussions-config-{$createdAt}.json";
        $json = json_encode($config->mappings->jsonSerialize(), JSON_PRETTY_PRINT);

        Storage::disk('local')->put($filename, $json);
        Storage::download($filename, $filename, ['Content-Type' => 'application/json']);
        Storage::delete($filename);
    }

    public function render(): View
    {
        return view('livewire.discussions-edit');
    }
}
