<?php

namespace App\Application\Breed\GetAllBreeds;

use App\Application\Breed\SynchronizeBreedSummaryList\SynchronizeBreedSummaryListInterface;
use App\Domain\Breed\BreedRepositoryInterface;

final readonly class GetAllBreeds implements GetAllBreedsInterface
{
    public function __construct(
        private SynchronizeBreedSummaryListInterface $synchronizeBreedSummaryList,
        private BreedRepositoryInterface $breedRepository
    ) {}

    public function __invoke(): array
    {
        $synchronize = $this->synchronizeBreedSummaryList;
        $synchronize();

        $breedSummaryList = $this->breedRepository->getAll();

        return collect($breedSummaryList)->pluck('name')->toArray();
    }
}
