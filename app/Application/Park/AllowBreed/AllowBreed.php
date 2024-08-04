<?php

namespace App\Application\Park\AllowBreed;

use App\Domain\Park\AllowBreed\AllowBreedCommand;
use App\Domain\Park\AllowBreed\AllowBreedInterface;
use App\Domain\Park\NotFoundParkException;
use App\Domain\Park\Park;
use App\Domain\Park\ParkId;
use App\Domain\Park\ParkRepositoryInterface;

final readonly class AllowBreed implements AllowBreedInterface
{
    public function __construct(
        private ParkRepositoryInterface $parkRepository
    ) {}

    public function __invoke(AllowBreedCommand $command): void
    {
        $park = $this->getPark($command->parkId);
        $park->allowAdditionalBreed($command->breedId);

        $this->parkRepository->save($park);
    }

    private function getPark(ParkId $parkId): Park
    {
        $park = $this->parkRepository->findOne($parkId);

        return $park ?? throw new NotFoundParkException();
    }
}
