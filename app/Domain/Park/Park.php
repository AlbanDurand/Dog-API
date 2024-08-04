<?php

namespace App\Domain\Park;

use App\Domain\Breed\Breed;
use App\Domain\Breed\BreedId;
use App\Domain\Breed\BreedSummary;
use App\Domain\Breed\BreedSummaryList;

final class Park
{
    /** @var array<BreedId> */
    private array $allowedBreeds;

    public function __construct(
        public readonly ParkId $id,
        private string $name
    ) {
        $this->allowedBreeds = [];
    }

    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return array<BreedId>
     */
    public function allowedBreeds(): array
    {
        return $this->allowedBreeds;
    }

    public function allowBreeds(BreedId ...$allowedBreeds): void
    {
        $this->allowedBreeds = array_unique($allowedBreeds, SORT_REGULAR);
    }

    public function allowAdditionalBreed(BreedId $breed): void
    {
        if (!in_array($breed, $this->allowedBreeds, true)) {
            $this->allowedBreeds[] = $breed;
        }
    }
}
