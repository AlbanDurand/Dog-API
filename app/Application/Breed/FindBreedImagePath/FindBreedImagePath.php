<?php

namespace App\Application\Breed\FindBreedImagePath;

use App\Domain\Breed\BreedExternalProvider\BreedExternalProviderInterface;
use Illuminate\Support\Arr;

final readonly class FindBreedImagePath implements FindBreedImagePathInterface
{
    public function __construct(
        private BreedExternalProviderInterface $breedExternalProvider
    ) {}

    public function __invoke(FindBreedImagePathQuery $query): ?string
    {
        $breed = $this->breedExternalProvider->fetchOneByName($query->breedName);

        return Arr::first($breed->imagePaths, default: null);
    }
}
