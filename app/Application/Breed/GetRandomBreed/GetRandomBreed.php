<?php

namespace App\Application\Breed\GetRandomBreed;

use App\Application\Breed\BreedDto;
use App\Domain\Breed\BreedExternalProvider\BreedExternalProviderInterface;

final readonly class GetRandomBreed implements GetRandomBreedInterface
{
    public function __construct(
        private BreedExternalProviderInterface $breedExternalProvider
    ) {}

    public function __invoke(): BreedDto
    {
        $breed = $this->breedExternalProvider->fetchOneRandomly();

        return new BreedDto($breed->name, $breed->imagePaths);
    }
}
