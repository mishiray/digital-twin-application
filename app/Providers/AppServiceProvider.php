<?php

namespace App\Providers;

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
        view()->composer('*', function ($view) {
            $view->with([
                'admin_source' => url('/') . env('ASSET_URL') . '/admins',
                'web_source' => url('/') . env('ASSET_URL'),
            ]);
        });
    }
}
