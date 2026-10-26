<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

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
        // Claves de Passport en storage/ y nombre de la cookie del token
        Passport::loadKeysFrom(storage_path());
        Passport::cookie('token');
    }
}
