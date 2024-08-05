<?php

namespace App\Application\Breed\GetBreed;

use App\Application\Breed\BreedDto;
use App\Application\Breed\SynchronizeBreed\SynchronizeBreedInterface;
use App\Application\Breed\SynchronizeBreed\SynchronizeBreedQuery;
use App\Domain\Breed\AvailablePark;
use App\Domain\Breed\Breed;
use App\Domain\Breed\BreedExternalProvider\BreedExternalProviderInterface;
use App\Domain\Breed\BreedId;
use App\Domain\Breed\BreedOwner;
use App\Domain\Breed\BreedRepositoryInterface;
use App\Domain\Breed\NotFoundBreedException;
use App\Domain\Breed\SubBreed;

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

        return $this->mapFromEntity($breed);
    }

    private function mapFromEntity(Breed $breed): BreedDto
    {
        return new BreedDto(
            $breed->name,
            array_map(function (SubBreed $subBreed): string {
                return $subBreed->name;
            }, $breed->subBreeds),
            $breed->imagePaths,
            array_map(function (BreedOwner $owner): array {
                return [
                    'id' => $owner->id->value,
                    'email' => $owner->email->value,
                    'name' => $owner->name,
                    'location' => $owner->location
                ];
            }, $breed->owners),
            array_map(function (AvailablePark $park): array {
                return [
                    'id' => $park->id->value,
                    'name' => $park->name
                ];
            }, $breed->parks)
        );
    }
}
