<?php

namespace App\Application\Breed\SynchronizeBreed;

use App\Application\TimeUnit\TimeUnitInterface;
use App\Domain\Breed\BreedId;
use App\Infrastructure\BreedSynchronizationRepository\BreedSynchronizationRepositoryInterface;

final readonly class DelayedBreedSynchronization implements SynchronizeBreedInterface
{
    public function __construct(
        private SynchronizeBreedInterface $synchronizeBreed,
        private BreedSynchronizationRepositoryInterface $breedSynchronizationRepository,
        private TimeUnitInterface $delay
    ) {}

    public function __invoke(SynchronizeBreedQuery $query): void
    {
        if ($this->isLastSynchronizationExpired(new BreedId($query->name))) {
            return;
        }

        $this->synchronizeBreed($query);
    }

    private function isLastSynchronizationExpired(BreedId $breedId): bool
    {
        return false === $this
            ->breedSynchronizationRepository
            ->isLastOneExpiredForBreed($breedId, $this->delay);
    }

    private function synchronizeBreed(SynchronizeBreedQuery $query): void
    {
        $synchronizeBreed = $this->synchronizeBreed;
        $synchronizeBreed($query);
    }
}
