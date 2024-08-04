<?php

namespace App\Domain\Breed;

use App\Domain\Shared\Exception\NotFoundEntityException;

class NotFoundBreedException extends NotFoundEntityException
{
    public function __construct(string $breedName)
    {
        parent::__construct('Breed named "' . $breedName . '" was not found.');
    }
}
