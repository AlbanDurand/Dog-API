<?php

namespace App\Domain\Park\AllowBreed;

interface AllowBreedInterface
{
    public function __invoke(AllowBreedCommand $command): void;
}
