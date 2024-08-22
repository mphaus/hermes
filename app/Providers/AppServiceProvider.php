<?php

namespace App\Providers;

use App\Http\Middleware\EnsureUserIsEnabled;
use App\Models\User;
use App\OpportunityItems;
use App\QET;
use App\UploadLog;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
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
        App::bind('opportunityitems', fn() => new OpportunityItems);
        App::bind('uploadlog', fn() => new UploadLog);
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

        Gate::before(fn(User $user) => $user->username === config('app.super_user.username') || $user->is_admin);

        Gate::define('crud-users', fn(User $user) => in_array('crud-users', $user->permissions->toArray()));

        Gate::define('access-equipment-import', fn(User $user) => in_array('access-equipment-import', $user->permissions->toArray()));

        Gate::define('access-action-stream', fn(User $user) => in_array('access-action-stream', $user->permissions->toArray()));

        Gate::define('create-default-discussions', fn(User $user) => in_array('create-default-discussions', $user->permissions->toArray()));

        Gate::define('update-default-discussions', fn(User $user) => in_array('update-default-discussions', $user->permissions->toArray()));
    }
}
