<?php

namespace App\Application\Owner\AttendToAdditionalPark;

use App\Domain\Owner\AttendToAdditionalPark\AttendToAdditionalParkCommand;
use App\Domain\Owner\AttendToAdditionalPark\AttendToAdditionalParkInterface;
use App\Domain\Owner\NotFoundOwnerException;
use App\Domain\Owner\Owner;
use App\Domain\Owner\OwnerId;
use App\Domain\Owner\OwnerRepositoryInterface;

final readonly class AttendToAdditionalPark implements AttendToAdditionalParkInterface
{
    public function __construct(
        private OwnerRepositoryInterface $ownerRepository
    ) {}

    /**
     * @throws NotFoundOwnerException
     */
    public function __invoke(AttendToAdditionalParkCommand $command): void
    {
        $owner = $this->getOwner($command->ownerId);
        $owner->attendAdditionalPark($command->parkId);

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
