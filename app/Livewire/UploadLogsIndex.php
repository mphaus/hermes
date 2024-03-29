<?php

namespace App\Livewire;

use App\Models\UploadLog;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

class UploadLogsIndex extends Component
{
    #[Locked]
    public int $jobId;

    public function mount(int $jobId): void
    {
        $this->jobId = $jobId;
    }

    #[Computed]
    public function logs(): Collection
    {
        return UploadLog::with('user')
            ->where('job_id', $this->jobId)
            ->latest()
            ->get();
    }

    public function render(): View
    {
        return view('livewire.upload-logs-index');
    }
}
