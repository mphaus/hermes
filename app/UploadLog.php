<?php

namespace App;

use App\Models\UploadLog as ModelsUploadLog;
use Illuminate\Support\Facades\Auth;

class UploadLog
{
    public function __construct(
        protected int $opportunity_id,
        protected array $opportunity_items_process
    ) {}

    public function save(): void
    {
        $log = new ModelsUploadLog();
        $log->job_id = $this->opportunity_id;
        $log->user()->associate(Auth::user());
        $log->status = $this->getStatus();
        $log->ip_address = request()->ip();
        $log->user_agent = request()->userAgent();
        $log->data = $this->opportunity_items_process;

        $log->save();
    }

    public function getStatus(): string
    {
        return empty(array_filter($this->opportunity_items_process, fn($process) => empty($process['error']) === false)) ? 'successful' : 'warnings';
    }
}
