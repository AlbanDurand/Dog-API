<?php

namespace App\Application\Breed\GetAllBreeds;

use App\Domain\Breed\BreedExternalProvider\BreedExternalProviderInterface;
use App\Domain\Breed\BreedSummary;

final readonly class GetAllBreeds implements GetAllBreedsInterface
{
    public function __construct(
        private BreedExternalProviderInterface $breedExternalProvider
    ) {}

    public function __invoke(): array
    {
        $breedSummaryList = $this->breedExternalProvider->fetchAll();

        return collect($breedSummaryList->items)
            ->map(fn (BreedSummary $breedSummary) => $breedSummary->name)
            ->toArray();
    }
}
