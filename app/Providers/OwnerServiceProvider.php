<?php

namespace App\Providers;

use App\Application\Owner\AssociateWithModel\AssociateWithModel;
use App\Application\Owner\AssociateWithModel\AssociateWithModelInterface;
use App\Application\Owner\AttendToAdditionalPark\AttendToAdditionalPark;
use App\Application\Owner\OwnAdditionalBreed\OwnAdditionalBreed;
use App\Domain\Owner\AttendToAdditionalPark\AttendToAdditionalParkInterface;
use App\Domain\Owner\OwnAdditionalBreed\OwnAdditionalBreedInterface;
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
        $this->app->singleton(AttendToAdditionalParkInterface::class, AttendToAdditionalPark::class);
        $this->app->singleton(OwnAdditionalBreedInterface::class, OwnAdditionalBreed::class);
        $this->app->singleton(AssociateWithModelInterface::class, AssociateWithModel::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
