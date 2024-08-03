<?php

namespace App\Application\Breed\SynchronizeBreed;

use App\Domain\Breed\Breed;
use App\Domain\Breed\BreedExternalProvider\BreedExternalProviderInterface;
use App\Domain\Breed\BreedId;
use App\Domain\Breed\BreedRepositoryInterface;
use App\Domain\Breed\NotFoundBreedException;
use App\Infrastructure\BreedSynchronizationRepository\BreedSynchronizationRepositoryInterface;
use App\Models\BreedSynchronization;
use Psr\Clock\ClockInterface;

final readonly class SynchronizeBreed implements SynchronizeBreedInterface
{
    public function __construct(
        private BreedExternalProviderInterface $breedExternalProvider,
        private BreedRepositoryInterface $breedRepository,
        private BreedSynchronizationRepositoryInterface $breedSynchronizationRepository,
        private ClockInterface $clock
    ) {}

    public function __invoke(SynchronizeBreedQuery $query): void
    {
        try {
            $breed = $this->fetchDistantBreed($query->name);

            $this->saveBreedLocally($breed);
            $this->saveExecutedSynchronization($query->name);
        } catch (NotFoundBreedException) {
            $this->deleteLocalBreed($query->name);
        }
    }

    /**
     * @throws NotFoundBreedException
     */
    private function fetchDistantBreed(string $breedName): Breed
    {
        return $this->breedExternalProvider->fetchOneByName($breedName);
    }

    private function saveBreedLocally(Breed $breed): void
    {
        $this->breedRepository->saveOne($breed);
    }

    private function saveExecutedSynchronization(string $breedName): void
    {
        $synchronization = new BreedSynchronization([
            'breed_name' => $breedName,
            'synchronized_at' => $this->clock->now()
        ]);

        $this->breedSynchronizationRepository->save($synchronization);
    }

    private function deleteLocalBreed(string $breedName): void
    {
        $this->breedRepository->delete(new BreedId($breedName));
    }
}
