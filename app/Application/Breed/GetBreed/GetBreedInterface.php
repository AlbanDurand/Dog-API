<?php

namespace App\Application\Breed\GetBreed;

use App\Application\Breed\BreedDto;

interface GetBreedInterface
{
    public function __invoke(GetBreedQuery $query): BreedDto;
}
