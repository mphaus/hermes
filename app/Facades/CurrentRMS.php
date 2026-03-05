<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array|object fetch(string $uri, array $params = [], bool $new_api = false)
 * @method static array|object store(string $uri, array $params = [], array $data = [], bool $new_api = false)
 *
 * @see \App\Services\CurrentRMSApiService
 */
class CurrentRMS extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'current-rms';
    }
}
