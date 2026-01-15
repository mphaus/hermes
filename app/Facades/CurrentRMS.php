<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array fetch(string $uri, array $params = [])
 * @method static array store(string $uri, array $params = [], array $data = [])
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
