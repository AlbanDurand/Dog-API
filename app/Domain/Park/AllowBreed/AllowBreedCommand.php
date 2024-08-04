<?php

namespace App\Domain\Park\AllowBreed;

use App\Domain\Breed\BreedId;
use App\Domain\Park\ParkId;

final readonly class AllowBreedCommand
{
    public function __construct(
        public ParkId $parkId,
        public BreedId $breedId
    ) {}
}
