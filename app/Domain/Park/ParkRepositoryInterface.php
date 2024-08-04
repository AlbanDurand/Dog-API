<?php

namespace App\Domain\Park;

interface ParkRepositoryInterface
{
    public function findOne(ParkId $id): ?Park;

    public function save(Park $park): void;
}
