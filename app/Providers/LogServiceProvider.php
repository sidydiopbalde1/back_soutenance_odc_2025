<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Logs\LogService;
use App\Repository\Logs\LogRepository;

class LogServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(LogService::class, function ($app) {
            return new LogService(new LogRepository());
        });
    }

    public function boot()
    {
        //
    }
}
