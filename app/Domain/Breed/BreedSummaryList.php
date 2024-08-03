<?php

namespace App\Domain\Breed;

final readonly class BreedSummaryList
{

    /** @var array<BreedSummary> */
    public array $items;

    public function __construct(BreedSummary ...$breedSummaries)
    {
        $this->items = $breedSummaries;
    }
}
