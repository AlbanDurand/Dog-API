<?php

namespace App\Providers;

use App\Application\Breed\FindBreedImagePath\FindBreedImagePath;
use App\Application\Breed\FindBreedImagePath\FindBreedImagePathInterface;
use App\Application\Breed\GetAllBreeds\GetAllBreeds;
use App\Application\Breed\GetAllBreeds\GetAllBreedsInterface;
use App\Application\Breed\GetBreed\GetBreed;
use App\Application\Breed\GetBreed\GetBreedInterface;
use App\Application\Breed\GetRandomBreed\GetRandomBreed;
use App\Application\Breed\GetRandomBreed\GetRandomBreedInterface;
use App\Application\Breed\SynchronizeBreedSummaryList\DelayedBreedSummaryListSynchronization;
use App\Application\Breed\SynchronizeBreedSummaryList\NextBreedSummaryListSynchronizationDelay;
use App\Application\Breed\SynchronizeBreedSummaryList\SynchronizeBreedSummaryList;
use App\Application\Breed\SynchronizeBreedSummaryList\SynchronizeBreedSummaryListInterface;
use App\Application\TimeUnit\Minute;
use App\Domain\Breed\BreedExternalProvider\BreedExternalProviderInterface;
use App\Domain\Breed\BreedRepositoryInterface;
use App\Infrastructure\BreedExternalProvider\BreedApiProvider;
use App\Infrastructure\BreedRepository\BreedRepository;
use App\Infrastructure\BreedSummaryListSynchronizationRepository\BreedSummaryListSynchronizationRepository;
use App\Infrastructure\BreedSummaryListSynchronizationRepository\BreedSummaryListSynchronizationRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Clock\Clock;

class BreedServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(BreedExternalProviderInterface::class, function () {
            return new BreedApiProvider('https://dog.ceo/api');
        });

        $this->app->singleton(GetAllBreedsInterface::class, GetAllBreeds::class);

        $this->app->singleton(GetBreedInterface::class, GetBreed::class);

        $this->app->singleton(GetRandomBreedInterface::class, GetRandomBreed::class);

        $this->app->singleton(FindBreedImagePathInterface::class, FindBreedImagePath::class);

        $this->app->singleton(BreedRepositoryInterface::class, BreedRepository::class);

        $this->app->singleton(
            BreedSummaryListSynchronizationRepositoryInterface::class,
            BreedSummaryListSynchronizationRepository::class
        );

        $this->app->singleton(SynchronizeBreedSummaryListInterface::class, SynchronizeBreedSummaryList::class);

        $this->app->extend(
            SynchronizeBreedSummaryList::class,
            function (SynchronizeBreedSummaryList $synchronize, Application $app) {
                return new DelayedBreedSummaryListSynchronization(
                    $synchronize,
                    new NextBreedSummaryListSynchronizationDelay(
                        $app->make(BreedSummaryListSynchronizationRepositoryInterface::class),
                        new Clock(),
                        new Minute(30)
                    )
                );
            }
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
