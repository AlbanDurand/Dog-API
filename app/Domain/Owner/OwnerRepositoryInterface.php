<?php

namespace App\Domain\Owner;

interface OwnerRepositoryInterface
{
    public function save(Owner $owner): void;
}
