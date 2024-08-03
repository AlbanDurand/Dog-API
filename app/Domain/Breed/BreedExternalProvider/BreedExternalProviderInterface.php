<?php

namespace App\Domain\Breed\BreedExternalProvider;

use App\Domain\Breed\NotFoundBreedException;
use App\Domain\Breed\Breed;
use App\Domain\Breed\BreedSummaryList;

interface BreedExternalProviderInterface
{
    public function fetchAll(): BreedSummaryList;

    /**
     * @throws NotFoundBreedException
     */
    public function fetchOneByName(string $breedName): Breed;

    public function fetchOneRandomly(): Breed;
}
