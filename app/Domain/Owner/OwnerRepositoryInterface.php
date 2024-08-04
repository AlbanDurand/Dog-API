<?php

namespace App\Domain\Owner;

interface OwnerRepositoryInterface
{
    public function save(Owner $owner): void;

    /**
     * @return array<Owner>
     */
    public function getAll(): array;

    public function findOne(OwnerId $id): ?Owner;
}
