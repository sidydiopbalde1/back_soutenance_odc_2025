<?php

namespace App\Providers;

use App\Services\campagne\CampagneService;
use App\Services\Interfaces\IDatabase;
use Illuminate\Support\ServiceProvider;

class CampagneServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(CampagneService::class, function ($app) {
            // Injecter automatiquement le service de base de données
            return new CampagneService($app->make(IDatabase::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
