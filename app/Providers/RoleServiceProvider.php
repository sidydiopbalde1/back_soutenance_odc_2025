<?php

namespace App\Providers;

use App\Services\Roles\RoleService;
use App\Services\Interfaces\IRole as IRoleService;
use App\Repository\Interfaces\IRole as IRoleRepository;
use App\Repository\Roles\RoleRepository ;
use Illuminate\Support\ServiceProvider;
class RoleServiceProvider extends ServiceProvider
{
   
    public function register(): void
    {
        $this->app->singleton(IRoleRepository::class, function () {
            return new RoleRepository();
        });
        $this->app->singleton(IRoleService::class, function ($app) {
           
            return new RoleService($app->make(RoleRepository::class));
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
