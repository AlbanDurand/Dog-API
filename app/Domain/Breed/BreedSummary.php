<?php

namespace App\Domain\Breed;

final readonly class BreedSummary
{
    public function __construct(
        public string $name
    ) {}
}
