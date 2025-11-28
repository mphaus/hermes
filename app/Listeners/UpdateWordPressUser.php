<?php

namespace App\Listeners;

use App\Events\UserUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateWordPressUser implements ShouldQueue
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
    public function handle(UserUpdated $event): void
    {
        $updated_user = $event->updated_user;
        $changes = $event->changes;
        $original_email = $event->original_email;
        $body = [];

        foreach ($changes as $field => $new_value) {
            if (in_array($field, ['first_name', 'last_name', 'email'])) {
                $body[$field] = $new_value;
            }
        }

        if (empty($body)) {
            return;
        }

        $email_to_search = isset($changes['email']) ? $original_email : $updated_user->email;

        $response = Http::withBasicAuth(
            config('app.wordpress.app_username'),
            config('app.wordpress.app_password')
        )->get(config('app.wordpress.rest_api_url') . 'users', [
            'context' => 'edit',
            'search' => $email_to_search,
            'per_page' => 1,
        ]);

        if ($response->failed()) {
            Log::error('Failed to fetch WordPress user for updating: ' . $response->body());
            return;
        }

        $wordpress_user = Arr::from($response->json());

        if (empty($wordpress_user)) {
            Log::info('No WordPress user for updating found with email: ' . $email_to_search);
            return;
        }

        $user_id = $wordpress_user[0]['id'];

        $response = Http::withBasicAuth(
            config('app.wordpress.app_username'),
            config('app.wordpress.app_password')
        )->post(config('app.wordpress.rest_api_url') . 'users/' . $user_id, $body);

        if ($response->failed()) {
            Log::error('Failed to update WordPress user with email: ' . $email_to_search . ': ' . $response->body());
        }
    }
}
