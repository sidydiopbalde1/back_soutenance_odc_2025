<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use App\Services\Auth\AuthService;
use App\Services\Interfaces\IAuth as IAuthService;
use App\Services\Logs\LogService;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];
    public function register(): void
    {
        $this->app->singleton(IAuthService::class, function ($app) {
            return new AuthService($app->make(LogService::class));
        });
    }
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        // Passport::routes();
    }
}
