<?php

namespace App\Application\Breed\GetAllBreeds;

interface GetAllBreedsInterface
{
    /**
     * @return array<string>
     */
    public function __invoke(): array;
}
