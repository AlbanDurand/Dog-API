<?php

namespace App\Application\Breed\GetBreed;

use App\Application\Breed\BreedDto;
use App\Domain\Breed\BreedExternalProvider\BreedExternalProviderInterface;

final readonly class GetBreed implements GetBreedInterface
{
    public function __construct(
        private BreedExternalProviderInterface $breedExternalProvider
    ) {}

    public function __invoke(GetBreedQuery $query): BreedDto
    {
        $breed = $this->breedExternalProvider->fetchOneByName($query->name);

        return new BreedDto($breed->name, $breed->imagePaths);
    }
}
