<?php

namespace App\Application\Delay;

interface DelayInterface
{
    public function isExpired(): bool;

    public function refresh(): void;
}
