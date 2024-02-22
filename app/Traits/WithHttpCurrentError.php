<?php

namespace App\Traits;

use Illuminate\Support\Arr;

trait WithHttpCurrentError
{
    public function errorMessage(string $message, array $errors = [], string $glue = ' '): string
    {
        if (empty($errors)) {
            return Arr::join([$message], $glue);
        }

        $_errors = [];

        array_walk_recursive($errors, function ($error) use (&$_errors) {
            $_errors[] = $error;
        });

        return Arr::join([
            $message,
            ...$_errors,
        ], $glue);
    }
}
