<?php

namespace App\Domain\Breed;

use App\Domain\Owner\OwnerId;
use App\Domain\Shared\Email\Email;

final readonly class BreedOwner
{
    public function __construct(
        public OwnerId $id,
        public Email $email,
        public string $name,
        public string $location
    ) {}
}
