<?php

namespace App\Providers;

use App\Repository\Interfaces\IService as InterfacesServiceRepository;
use App\Repository\Services\ServiceRepository;
use App\Services\Interfaces\IService as InterfacesServiceService;
use App\Services\Logs\LogService;
use App\Services\Service\ServiceService;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(InterfacesServiceRepository::class, function () {
            return new ServiceRepository();
        });
        $this->app->singleton(InterfacesServiceService::class, function ($app) {
           
            return new ServiceService($app->make(ServiceRepository::class),$app->make(LogService::class));
        });
    }
    
    

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        

    }
}
