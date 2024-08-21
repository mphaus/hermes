<?php

namespace App\Providers;

use App\Http\Middleware\EnsureUserIsEnabled;
use App\Models\User;
use App\OpportunityItems;
use App\QET;
use App\UploadLog;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
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

        $macroCallback = function () {
            return Http::withHeaders([
                'X-AUTH-TOKEN' => config('app.current_rms.auth_token'),
                'X-SUBDOMAIN' => config('app.current_rms.subdomain'),
            ])->baseUrl(config('app.current_rms.host'));
        };

        Http::macro('current', $macroCallback);
    }
}
