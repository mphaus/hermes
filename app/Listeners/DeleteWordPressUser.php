<?php

namespace App\Listeners;

use App\Events\UserDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DeleteWordPressUser implements ShouldQueue
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
    public function handle(UserDeleted $event): void
    {
        $email = $event->email;

        $response = Http::withBasicAuth(
            config('app.wordpress.app_username'),
            config('app.wordpress.app_password')
        )->get(config('app.wordpress.rest_api_url') . 'users', [
            'context' => 'edit',
            'search' => $email,
            'per_page' => 1,
        ]);

        if ($response->failed()) {
            Log::error('Failed to fetch WordPress user for deletion: ' . $response->body());
            return;
        }

        $wordpress_user = Arr::from($response->json());

        if (empty($wordpress_user)) {
            Log::info('No WordPress user found with email: ' . $email);
            return;
        }

        $user_id = $wordpress_user[0]['id'];

        $response = Http::withBasicAuth(
            config('app.wordpress.app_username'),
            config('app.wordpress.app_password')
        )->delete(config('app.wordpress.rest_api_url') . 'users/' . $user_id, [
            'reassign' => 1,
            'force' => true,
        ]);

        if ($response->failed()) {
            Log::error('Failed to delete WordPress user with email: ' . $email . ': ' . $response->body());
        }
    }
}
