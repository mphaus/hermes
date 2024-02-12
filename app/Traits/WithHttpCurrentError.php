<?php

namespace App\Traits;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;

trait WithHttpCurrentError
{
    public function errorMessage(string $message, Response|null $response = null, string $glue = ' '): string
    {
        if ($response === null) {
            return Arr::join([$message], ' ');
        }

        $errors = [];

        array_walk_recursive($response->json()['errors'], function ($error) use (&$errors) {
            $errors[] = $error;
        });

        return Arr::join([
            $message,
            ...$errors,
        ], $glue);
    }
}
