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
            'name' => $user->full_name, // Nickname
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email'    => $user->email,
            'password' => $user->username,
            'roles'    => 'employee'
        ];

        // Make a POST request to the WordPress REST API to create the user
        $response = Http::withBasicAuth(
            config('app.wordpress.app_username'),
            config('app.wordpress.app_password')
        )->post(config('app.wordpress.rest_api_url') . 'users', $data);

        if ($response->failed()) {
            // Handle failure (log error, retry, etc.)
            Log::error('Failed to create WordPress user for: ' . $user->email, [
                'response' => $response->body(),
            ]);
        }
    }
}
