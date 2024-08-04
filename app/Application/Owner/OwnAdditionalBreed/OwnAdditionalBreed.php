<?php

namespace App\Application\Owner\OwnAdditionalBreed;

use App\Domain\Owner\NotFoundOwnerException;
use App\Domain\Owner\OwnAdditionalBreed\OwnAdditionalBreedCommand;
use App\Domain\Owner\OwnAdditionalBreed\OwnAdditionalBreedInterface;
use App\Domain\Owner\Owner;
use App\Domain\Owner\OwnerId;
use App\Domain\Owner\OwnerRepositoryInterface;

final readonly class OwnAdditionalBreed implements OwnAdditionalBreedInterface
{
    public function __construct(
        private OwnerRepositoryInterface $ownerRepository
    ) {}

    /**
     * @throws NotFoundOwnerException
     */
    public function __invoke(OwnAdditionalBreedCommand $command): void
    {
        $owner = $this->getOwner($command->ownerId);
        $owner->ownAdditionalBreed($command->breedId);

        $this->ownerRepository->save($owner);
    }

    /**
     * @throws NotFoundOwnerException
     */
    private function getOwner(OwnerId $ownerId): Owner
    {
        $owner = $this->ownerRepository->findOne($ownerId);

        return $owner ?? throw new NotFoundOwnerException();
    }
}
