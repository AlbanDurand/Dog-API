<?php

namespace App\Domain\Breed;

final readonly class Breed
{
    public function __construct(
        public string $name,

        /** @param array<string> $imagePaths */
        public array $imagePaths = [],

        /** @param array<BreedOwner> $owners */
        public array $owners = [],

        /** @param array<AvailablePark> $parks */
        public array $parks = []
    ) {}
}
