<?php

namespace App\Application\Breed\SynchronizeBreedSummaryList;

use App\Application\Delay\DelayInterface;
use App\Application\TimeUnit\TimeUnitInterface;
use App\Infrastructure\BreedSummaryListSynchronizationRepository\BreedSummaryListSynchronizationRepositoryInterface;

final readonly class NextBreedSummaryListSynchronizationDelay implements DelayInterface
{
    public function __construct(
        private BreedSummaryListSynchronizationRepositoryInterface $synchronizationRepository,
        private TimeUnitInterface $delay
    ) {}

    public function isExpired(): bool
    {
        return $this->synchronizationRepository->isLastOneExpired($this->delay);
    }
}
