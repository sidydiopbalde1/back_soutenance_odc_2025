<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use App\Services\Interfaces\IMail ;
use App\Services\Mail\MailService; 

class MailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(IMail::class, function () {

            return new MailService();
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
