<?php

namespace App\Providers;

use App\Services\Users\UserService;
use App\Services\Interfaces\IUser as IUserService;
use App\Repository\Interfaces\IUser as IUserRepository;
use App\Repository\Users\UserRepository;

use Illuminate\Support\ServiceProvider;
use App\Services\Mail\MailService;
class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(IUserRepository::class, function () {
            return new UserRepository();
        });
        $this->app->singleton(IUserService::class, function ($app) {
           
            return new UserService($app->make(UserRepository::class),$app->make(MailService::class));
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
