<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Psr\Clock\ClockInterface;
use Symfony\Component\Clock\Clock;

class ClockServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ClockInterface::class, function () {
            return new Clock();
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
