<?php

namespace App\Providers;

use App\OpportunityItems;
use App\UploadLog;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        App::bind('opportunityitems', fn () => new OpportunityItems);
        App::bind('uploadlog', fn () => new UploadLog);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $macroCallback = function () {
            return Http::withHeaders([
                'X-AUTH-TOKEN' => config('app.current_rms.auth_token'),
                'X-SUBDOMAIN' => config('app.current_rms.subdomain'),
            ])->baseUrl(config('app.current_rms.host'));
        };

        Http::macro('current', $macroCallback);
    }
}
