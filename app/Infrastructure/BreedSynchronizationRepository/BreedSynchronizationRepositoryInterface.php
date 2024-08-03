<?php

namespace App\Infrastructure\BreedSynchronizationRepository;

use App\Application\TimeUnit\TimeUnitInterface;
use App\Domain\Breed\BreedId;
use App\Models\BreedSynchronization;

interface BreedSynchronizationRepositoryInterface
{
    public function save(BreedSynchronization $breedSynchronization): void;

    public function isLastOneExpiredForBreed(BreedId $breedId, TimeUnitInterface $delay): bool;
}
