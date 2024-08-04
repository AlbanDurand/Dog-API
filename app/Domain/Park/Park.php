<?php

namespace App\Domain\Park;

use App\Domain\Breed\Breed;
use App\Domain\Breed\BreedId;
use App\Domain\Breed\BreedSummary;
use App\Domain\Breed\BreedSummaryList;

final class Park
{
    private BreedSummaryList $allowedBreeds;

    public function __construct(
        public readonly ParkId $id,
        private string $name
    ) {}

    public function name(): string
    {
        return $this->name;
    }

    public function allowedBreeds(): BreedSummaryList
    {
        return $this->allowedBreeds;
    }

    public function allowBreeds(BreedSummaryList $allowedBreeds): void
    {
        $this->allowedBreeds = $allowedBreeds;
    }

    public function allowNewBreed(BreedSummary|Breed|BreedId $breed): void
    {
        $breedSummary = match (true) {
            $breed instanceof BreedId => new BreedSummary($breed->value),
            $breed instanceof Breed => new BreedSummary($breed->name),
            default => $breed,
        };

        /** @var BreedSummary $allowedBreed */
        foreach ($this->allowedBreeds as $allowedBreed) {
            if ($allowedBreed->name === $breedSummary->name) {
                return;
            }
        }

        $this->allowedBreeds = new BreedSummaryList(
            $breedSummary, ...$this->allowedBreeds->items
        );
    }
}
