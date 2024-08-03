<?php

namespace App\Application\Breed\GetRandomBreed;

use App\Application\Breed\BreedDto;

interface GetRandomBreedInterface
{
    public function __invoke(): BreedDto;
}
