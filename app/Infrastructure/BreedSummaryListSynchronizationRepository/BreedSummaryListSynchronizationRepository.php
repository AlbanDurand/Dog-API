<?php

namespace App\Infrastructure\BreedSummaryListSynchronizationRepository;

use App\Application\TimeUnit\TimeUnitInterface;
use App\Models\BreedSummaryListSynchronization;
use Carbon\Carbon;
use DateTimeInterface;

class BreedSummaryListSynchronizationRepository implements BreedSummaryListSynchronizationRepositoryInterface
{
    public function saveNew(DateTimeInterface $synchronizedAt): void
    {
        BreedSummaryListSynchronization::create([
            'synchronized_at' => $synchronizedAt
        ]);
    }

    public function isLastOneExpired(TimeUnitInterface $delay): bool
    {
        return BreedSummaryListSynchronization::where(
            'synchronized_at',
            '>',
            Carbon::now()->subSeconds($delay->toSeconds())
        )->count() === 0;
    }
}
