<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Http::macro('cresol', function () {
            return Http::withoutVerifying()
                ->baseUrl(env('API_BASE_URL'))
                ->withOptions([
                    'proxy' => env('FIXIE_URL'),
                    'timeout' => 15
                ]);
        });


        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
