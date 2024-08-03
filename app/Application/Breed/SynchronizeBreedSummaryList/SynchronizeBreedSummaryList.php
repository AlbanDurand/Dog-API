<?php

namespace App\Application\Breed\SynchronizeBreedSummaryList;

use App\Domain\Breed\BreedExternalProvider\BreedExternalProviderInterface;
use App\Domain\Breed\BreedId;
use App\Domain\Breed\BreedRepositoryInterface;
use App\Domain\Breed\BreedSummary;
use App\Domain\Breed\BreedSummaryList;

final readonly class SynchronizeBreedSummaryList implements SynchronizeBreedSummaryListInterface
{
    public function __construct(
      private BreedExternalProviderInterface $breedExternalProvider,
      private BreedRepositoryInterface $breedRepository
    ) {}

    public function __invoke(): void
    {
        $this->syncBreeds(
            $this->breedRepository->getAll(),
            $this->breedExternalProvider->fetchAll()
        );
    }

    private function syncBreeds(
        BreedSummaryList $storedBreeds,
        BreedSummaryList $breedsFromProvider
    ): void {
        $this->deleteBreedsMissingFromExternalProvider($storedBreeds, $breedsFromProvider);
        $this->save($breedsFromProvider);
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

    private function save(BreedSummaryList $breedsFromProvider): void
    {
        $this->breedRepository->saveMany($breedsFromProvider);
    }
}
