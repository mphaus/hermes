<?php

namespace App\Providers;

use App\Events\UserCreated;
use App\Http\Middleware\EnsureUserIsEnabled;
use App\Models\User;
use App\QET;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        App::bind('qet', fn() => new QET);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Livewire::addPersistentMiddleware([
            EnsureUserIsEnabled::class,
        ]);

        Http::macro('current', function () {
            return Http::withHeaders([
                'X-AUTH-TOKEN' => config('app.current_rms.auth_token'),
                'X-SUBDOMAIN' => config('app.current_rms.subdomain'),
            ])->baseUrl(config('app.current_rms.host'));
        });

        User::created(fn(User $user) => event(new UserCreated($user)));
    }
}
