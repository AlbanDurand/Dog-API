<?php

namespace App\Infrastructure\OwnerRepository;

use App\Domain\Owner\Owner;
use App\Domain\Owner\OwnerRepositoryInterface;

final readonly class OwnerRepository implements OwnerRepositoryInterface
{
    public function save(Owner $owner): void
    {
        // TODO: Implement save() method.
    }
}
