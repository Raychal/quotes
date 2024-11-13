<?php

namespace App\Providers;

use Dedoc\Scramble\Scramble;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;

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
        Vite::prefetch(concurrency: 3);
        Scramble::routes(function (Route $route) {
            return Str::startsWith($route->uri, 'api/');
        });
    }
}
