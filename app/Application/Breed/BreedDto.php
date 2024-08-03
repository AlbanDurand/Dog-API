<?php

namespace App\Application\Breed;

final readonly class BreedDto
{
    public function __construct(public string $name, public array $imagePaths)
    {}
}
