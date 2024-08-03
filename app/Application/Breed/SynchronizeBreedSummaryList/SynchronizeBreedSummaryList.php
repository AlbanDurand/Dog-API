<?php

namespace App\Application\Breed\SynchronizeBreedSummaryList;

use App\Domain\Breed\BreedExternalProvider\BreedExternalProviderInterface;
use App\Domain\Breed\BreedId;
use App\Domain\Breed\BreedRepositoryInterface;
use App\Domain\Breed\BreedSummaryList;
use App\Infrastructure\BreedSummaryListSynchronizationRepository\BreedSummaryListSynchronizationRepositoryInterface;
use Psr\Clock\ClockInterface;

final readonly class SynchronizeBreedSummaryList implements SynchronizeBreedSummaryListInterface
{
    public function __construct(
        private BreedExternalProviderInterface $breedExternalProvider,
        private BreedRepositoryInterface $breedRepository,
        private BreedSummaryListSynchronizationRepositoryInterface $breedSummaryListSynchronizationRepository,
        private ClockInterface $clock
    ) {}

    public function __invoke(): void
    {
        $this->syncBreeds(
            $this->breedRepository->getAll(),
            $this->breedExternalProvider->fetchAll()
        );

        $this->saveExecutedSynchronization();
    }

    private function syncBreeds(
        BreedSummaryList $storedBreeds,
        BreedSummaryList $breedsFromProvider
    ): void {
        $this->deleteBreedsMissingFromExternalProvider($storedBreeds, $breedsFromProvider);
        $this->saveBreedsLocally($breedsFromProvider);
    }

    private function deleteBreedsMissingFromExternalProvider(
        BreedSummaryList $storedBreeds,
        BreedSummaryList $breedsFromProvider
    ): void {
        /** @var BreedId[] $breedsToDelete */
        $breedsToDelete = collect($storedBreeds)
            ->pluck('name')
            ->diff(collect($breedsFromProvider)->pluck('name'))
            ->map(fn (string $name) => new BreedId($name))
            ->toArray();

        $this->breedRepository->delete(...$breedsToDelete);
    }

    private function saveBreedsLocally(BreedSummaryList $breedsFromProvider): void
    {
        $this->breedRepository->saveMany($breedsFromProvider);
    }

    private function saveExecutedSynchronization(): void
    {
        $this->breedSummaryListSynchronizationRepository->saveNew($this->clock->now());
    }
}
