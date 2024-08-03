<?php

namespace App\Domain\Breed;

use Traversable;

final readonly class BreedSummaryList implements \IteratorAggregate
{

    /** @var array<BreedSummary> */
    public array $items;

    public function __construct(BreedSummary ...$breedSummaries)
    {
        $this->items = $breedSummaries;
    }

    public function getIterator(): Traversable
    {
        foreach ($this->items as $breedSummary) {
            yield $breedSummary;
        }
    }
}
