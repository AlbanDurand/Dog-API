<?php

namespace App\Domain\Owner;

final readonly class OwnerId
{
    public function __construct(public string $value)
    {}
}
