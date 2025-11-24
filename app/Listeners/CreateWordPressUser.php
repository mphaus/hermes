<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CreateWordPressUser implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserCreated $event): void
    {
        $user = $event->user;

        // Prepare the data for the WordPress user creation
        $data = [
            'username' => $user->username,
            'email'    => $user->email,
            'password' => $user->password, // Ensure this is hashed appropriately
            'roles'    => ['employee'], // Assign default role
        ];

        // Make a POST request to the WordPress REST API to create the user
        $response = Http::withBasicAuth(
            env('WORDPRESS_APP_USERNAME'),
            env('WORDPRESS_APP_PASSWORD')
        )->post(env('WORDPRESS_REST_API_URL') . 'users', $data);

        if ($response->failed()) {
            // Handle failure (log error, retry, etc.)
            // Log::error('Failed to create WordPress user for: ' . $user->email, [
            //     'response' => $response->body(),
            // ]);
        }
    }
}
