<?php

namespace App\Domain\Breed;

final readonly class Breed
{
    /**
     * @param array<SubBreed>  $subBreeds
     * @param array<string>  $imagePaths
     * @param array<BreedOwner>  $owners
     * @param array<AvailablePark>  $parks
     */
    public function __construct(
        public string $name,

        public array $subBreeds = [],

        public array $imagePaths = [],

        public array $owners = [],

        public array $parks = []
    ) {}
}
