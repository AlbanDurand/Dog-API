<?php

namespace App\Application\Breed\GetBreed;

use App\Application\Breed\BreedDto;
use App\Application\Breed\SynchronizeBreed\SynchronizeBreedInterface;
use App\Application\Breed\SynchronizeBreed\SynchronizeBreedQuery;
use App\Domain\Breed\BreedExternalProvider\BreedExternalProviderInterface;
use App\Domain\Breed\BreedId;
use App\Domain\Breed\BreedRepositoryInterface;
use App\Domain\Breed\NotFoundBreedException;

final readonly class GetBreed implements GetBreedInterface
{
    public function __construct(
        private SynchronizeBreedInterface $synchronizeBreed,
        private BreedRepositoryInterface $breedRepository
    ) {}

    /**
     * @throws NotFoundBreedException
     */
    public function __invoke(GetBreedQuery $query): BreedDto
    {
        $synchronizeBreed = $this->synchronizeBreed;
        $synchronizeBreed(new SynchronizeBreedQuery($query->name));

        $breed = $this->breedRepository->findOne(new BreedId($query->name));

        if ($breed === null) {
            throw new NotFoundBreedException($query->name);
        }

        return new BreedDto($breed->name, $breed->imagePaths);
    }
}
