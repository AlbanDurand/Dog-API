<?php

namespace App\Infrastructure\BreedSynchronizationRepository;

use App\Application\TimeUnit\TimeUnitInterface;
use App\Domain\Breed\BreedId;
use App\Models\BreedSynchronization;
use Carbon\Carbon;

final readonly class BreedSynchronizationRepository implements BreedSynchronizationRepositoryInterface
{
    public function save(BreedSynchronization $breedSynchronization): void
    {
        $breedSynchronization->save();
    }

    public function isLastOneExpiredForBreed(
        BreedId $breedId,
        TimeUnitInterface $delay
    ): bool {
        return BreedSynchronization::where(
            'synchronized_at',
            '>',
            Carbon::now()->subSeconds($delay->toSeconds())
        )
            ->where('breed_name', $breedId->value)
            ->count() === 0;
    }
}
