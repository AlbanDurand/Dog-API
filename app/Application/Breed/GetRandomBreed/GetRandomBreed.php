<?php

namespace App\Application\Breed\GetRandomBreed;

use App\Application\Breed\BreedDto;
use App\Application\Breed\GetBreed\GetBreedInterface;
use App\Application\Breed\GetBreed\GetBreedQuery;
use App\Domain\Breed\BreedExternalProvider\BreedExternalProviderInterface;

final readonly class GetRandomBreed implements GetRandomBreedInterface
{
    public function __construct(
        private BreedExternalProviderInterface $breedExternalProvider,
        private GetBreedInterface $getBreed
    ) {}

    public function __invoke(): BreedDto
    {
        $breed = $this->breedExternalProvider->fetchOneRandomly();

        $getBreed = $this->getBreed;

        return $getBreed(new GetBreedQuery($breed->name));
    }
}
