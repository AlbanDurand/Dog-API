<?php

namespace App\Application\Breed\SynchronizeBreed;

interface SynchronizeBreedInterface
{
    public function __invoke(SynchronizeBreedQuery $query): void;
}
