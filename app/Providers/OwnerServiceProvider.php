<?php

namespace App\Providers;

use App\Domain\Owner\OwnerRepositoryInterface;
use App\Infrastructure\OwnerRepository\OwnerRepository;
use Illuminate\Support\ServiceProvider;

class OwnerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(OwnerRepositoryInterface::class, OwnerRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
