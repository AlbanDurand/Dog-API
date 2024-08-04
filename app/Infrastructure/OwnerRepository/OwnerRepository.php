<?php

namespace App\Infrastructure\OwnerRepository;

use App\Domain\Owner\Owner;
use App\Domain\Owner\OwnerId;
use App\Domain\Owner\OwnerRepositoryInterface;

final readonly class OwnerRepository implements OwnerRepositoryInterface
{
    public function save(Owner $owner): void
    {
        // TODO: Implement save() method.
    }

    public function getAll(): array
    {
        // TODO: Implement getAll() method.
    }

    public function findOne(OwnerId $id): ?Owner
    {
        // TODO: Implement findOne() method.
    }
}
