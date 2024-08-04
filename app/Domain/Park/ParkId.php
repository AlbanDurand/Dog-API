<?php

namespace App\Domain\Park;

final readonly class ParkId
{
    public function __construct(public string $value)
    {}
}
