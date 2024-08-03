<?php

namespace App\Application\Breed\FindBreedImagePath;

interface FindBreedImagePathInterface
{
    public function __invoke(FindBreedImagePathQuery $query): ?string;
}
