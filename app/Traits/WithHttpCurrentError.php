<?php

namespace App\Traits;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;

trait WithHttpCurrentError
{
    public function errorMessage(string $message, Response $response): string
    {
        return Arr::join([
            $message,
            ...$response->json()['errors'],
        ], ' ');
    }
}
