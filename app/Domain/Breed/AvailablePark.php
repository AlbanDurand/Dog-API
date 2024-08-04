<?php

namespace App\Domain\Breed;

use App\Domain\Park\ParkId;

final readonly class AvailablePark
{
    public function __construct(public ParkId $id, public string $name)
    {}
}
