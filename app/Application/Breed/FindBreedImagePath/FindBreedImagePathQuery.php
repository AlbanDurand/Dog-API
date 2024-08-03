<?php

namespace App\Application\Breed\FindBreedImagePath;

final readonly class FindBreedImagePathQuery
{
    public function __construct(public string $breedName)
    {}
}
