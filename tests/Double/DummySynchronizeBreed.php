<?php

namespace Tests\Double;

use App\Application\Breed\SynchronizeBreed\SynchronizeBreedInterface;
use App\Application\Breed\SynchronizeBreed\SynchronizeBreedQuery;

class DummySynchronizeBreed implements SynchronizeBreedInterface
{
    public function __invoke(SynchronizeBreedQuery $query): void
    {}
}
