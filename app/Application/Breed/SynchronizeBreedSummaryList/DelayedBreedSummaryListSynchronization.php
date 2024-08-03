<?php

namespace App\Application\Breed\SynchronizeBreedSummaryList;

use App\Application\Delay\DelayInterface;

final readonly class DelayedBreedSummaryListSynchronization implements SynchronizeBreedSummaryListInterface
{
    public function __construct(
        private SynchronizeBreedSummaryListInterface $synchronize,
        private DelayInterface $delay
    ) {}

    public function __invoke(): void
    {
        if ($this->delay->isExpired() === false) {
            return;
        }

        $synchronize = $this->synchronize;
        $synchronize();
    }
}
