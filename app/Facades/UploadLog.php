<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class UploadLog extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'uploadlog';
    }
}
