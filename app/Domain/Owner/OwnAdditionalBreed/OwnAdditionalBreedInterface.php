<?php

namespace App\Domain\Owner\OwnAdditionalBreed;

use App\Domain\Owner\NotFoundOwnerException;

interface OwnAdditionalBreedInterface
{
    /**
     * @throws NotFoundOwnerException
     */
    public function __invoke(OwnAdditionalBreedCommand $command): void;
}
