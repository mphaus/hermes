<?php

namespace App;

use App\Models\UploadLog as ModelsUploadLog;
use Illuminate\Support\Facades\Auth;

class UploadLog
{
    public function save(int $id, array $uploadLog): void
    {
        $log = new ModelsUploadLog();
        $log->job_id = $id;
        $log->user()->associate(Auth::user());
        $log->status = $this->getStatus($uploadLog);
        $log->ip_address = request()->ip();
        $log->user_agent = request()->userAgent();
        $log->data = $uploadLog;

        $log->save();
    }

    public function getStatus(array $uploadLog): string
    {
        return empty(array_filter($uploadLog, fn($log) => empty($log['error']) === false)) ? 'successful' : 'warnings';
    }
}
