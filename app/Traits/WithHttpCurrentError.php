<?php

namespace App\Traits;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;

trait WithHttpCurrentError
{
    public function errorMessage(string $message, Response|null $response = null): string
    {
        if ($response === null) {
            return Arr::join([$message], ' ');
        }

        return Arr::join([
            $message,
            ...$response->json()['errors'],
        ], ' ');
    }
}
