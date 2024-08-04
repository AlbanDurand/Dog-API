<?php

namespace Tests\Double;

use App\Domain\Breed\Breed;
use App\Domain\Breed\BreedExternalProvider\BreedExternalProviderInterface;
use App\Domain\Breed\BreedSummary;
use App\Domain\Breed\BreedSummaryList;

class InMemoryBreedExternalProvider implements BreedExternalProviderInterface
{
    public function __construct(
        private array $breedSummaries = []
    ) {}

    public function fetchAll(): BreedSummaryList
    {
        return new BreedSummaryList(...$this->breedSummaries);
    }

    public function fetchOneByName(string $breedName): Breed
    {
        // TODO: Implement fetchOneByName() method.
    }

    public function fetchOneRandomly(): Breed
    {
        // TODO: Implement fetchOneRandomly() method.
    }
}
