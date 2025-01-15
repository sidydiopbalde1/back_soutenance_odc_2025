<?php

namespace App\Providers;

use App\Services\Interfaces\IDatabase;
use App\Services\Mongoose\MongoDBService;
use Illuminate\Support\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->bind(IDatabase::class, function () {
            $driver = env('DATABASE_DRIVER', 'mongodb');
            return match ($driver) {
                // Ajoutez d'autres implémentations ici si nécessaire
                'mongodb' => new MongoDBService(),
                default => throw new \Exception("Unsupported database driver: $driver"),
            };
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
