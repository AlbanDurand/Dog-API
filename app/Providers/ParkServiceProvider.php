<?php

namespace App\Providers;

use App\Application\Park\AllowBreed\AllowBreed;
use App\Domain\Park\AllowBreed\AllowBreedInterface;
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
        $this->app->singleton(AllowBreedInterface::class, AllowBreed::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
