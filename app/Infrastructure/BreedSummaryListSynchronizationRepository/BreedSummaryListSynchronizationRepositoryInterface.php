<?php

namespace App\Infrastructure\BreedSummaryListSynchronizationRepository;

use App\Application\TimeUnit\TimeUnitInterface;
use DateTimeInterface;

interface BreedSummaryListSynchronizationRepositoryInterface
{
    public function saveNew(DateTimeInterface $synchronizedAt): void;

    public function isLastOneExpired(TimeUnitInterface $timeUnit): bool;
}
