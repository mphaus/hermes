<?php

namespace App\Livewire;

use App\Models\UploadLog;
use Livewire\Attributes\Computed;
use Livewire\Component;

class UploadLogsShow extends Component
{
    protected int $id;

    public function mount(int $id): void
    {
        $this->id = $id;
    }

    #[Computed]
    public function log(): UploadLog
    {
        return UploadLog::with('user')->findOrFail($this->id);
    }

    public function render()
    {
        return view('livewire.upload-logs-show');
    }
}
