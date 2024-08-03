<?php

namespace App\Application\Breed\GetBreed;

use App\Application\Breed\BreedDto;
use App\Domain\Breed\NotFoundBreedException;

interface GetBreedInterface
{
    /**
     * @throws NotFoundBreedException
     */
    public function __invoke(GetBreedQuery $query): BreedDto;
}
