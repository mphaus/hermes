<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Services\CurrentRMSApiService|array fetch(string $uri, array $params = [])
 * @method static \App\Services\CurrentRMSApiService|array store(string $uri, array $params = [], array $data = [])
 * @method static \App\Services\CurrentRMSApiService update(string $uri, array $params = [], array $data = [])
 * @method static bool hasErrors()
 * @method static string getErrorString()
 * @method static int getErrorStatus()
 * @method static mixed getData()
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
