<?php

namespace App\Domain\Owner\OwnAdditionalBreed;

use App\Domain\Breed\BreedId;
use App\Domain\Owner\OwnerId;

final readonly class OwnAdditionalBreedCommand
{
    public function __construct(
        public OwnerId $ownerId,
        public BreedId $breedId
    ) {}
}
