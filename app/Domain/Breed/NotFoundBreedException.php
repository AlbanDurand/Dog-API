<?php

namespace App\Domain\Breed;

use Exception;

class NotFoundBreedException extends Exception
{
    public function __construct(string $breedName)
    {
        parent::__construct('Breed named "' . $breedName . '" was not found.');
    }
}
