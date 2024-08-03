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
use App\Domain\Breed\BreedExternalProvider\BreedExternalProviderInterface;
use App\Infrastructure\BreedExternalProvider\BreedApiProvider;
use Illuminate\Support\ServiceProvider;

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
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
