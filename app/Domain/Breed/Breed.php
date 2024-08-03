<?php

namespace App\Domain\Breed;

final readonly class Breed
{
    public function __construct(
        public string $name,

        /** @param array<string> $imagePaths */
        public array $imagePaths
    ) {}
}
