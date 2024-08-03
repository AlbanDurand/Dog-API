<?php

namespace App\Application\TimeUnit;

final readonly class Minute implements TimeUnitInterface
{
    public function __construct(private int $value)
    {}

    public function toSeconds(): int
    {
        return $this->value * 60;
    }
}
