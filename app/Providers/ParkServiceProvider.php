<?php

namespace App\Providers;

use App\Domain\Park\ParkRepositoryInterface;
use App\Infrastructure\ParkRepository\ParkRepository;
use Illuminate\Support\ServiceProvider;

class ParkServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ParkRepositoryInterface::class, ParkRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
