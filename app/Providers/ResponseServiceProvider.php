<?php
namespace App\Providers;

use App\Services\Responses\RestResponseService;
use App\Services\Responses\ResourceMappingService;
use Illuminate\Support\ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Enregistrement des services.
     */
    public function register()
    {
        // Enregistrer RestResponseService
        $this->app->singleton(RestResponseService::class, function ($app) {
            return new RestResponseService();
        });

        // Enregistrer ResourceMappingService
        $this->app->singleton(ResourceMappingService::class, function ($app) {
            return new ResourceMappingService();
        });
    }

    /**
     * Démarrage des services.
     */
    public function boot()
    {
        //
    }
}
