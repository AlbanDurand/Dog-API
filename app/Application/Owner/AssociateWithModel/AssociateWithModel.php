<?php

namespace App\Application\Owner\AssociateWithModel;

use App\Domain\Breed\BreedId;
use App\Domain\Owner\AttendToAdditionalPark\AttendToAdditionalParkCommand;
use App\Domain\Owner\AttendToAdditionalPark\AttendToAdditionalParkInterface;
use App\Domain\Owner\OwnAdditionalBreed\OwnAdditionalBreedCommand;
use App\Domain\Owner\OwnAdditionalBreed\OwnAdditionalBreedInterface;
use App\Domain\Owner\OwnerId;
use App\Domain\Park\ParkId;
use InvalidArgumentException;

final readonly class AssociateWithModel implements AssociateWithModelInterface
{
    public function __construct(
        private AttendToAdditionalParkInterface $attendToAdditionalPark,
        private OwnAdditionalBreedInterface $ownAdditionalBreed
    ) {}

    public function __invoke(AssociateWithModelCommand $command): void
    {
        switch ($command->relatedModelType) {
            case 'park':
                $commandHandler = $this->attendToAdditionalPark;
                $command = new AttendToAdditionalParkCommand(
                    new OwnerId($command->ownerId),
                    new ParkId($command->relatedModelId)
                );
                break;

            case 'breed':
                $commandHandler = $this->ownAdditionalBreed;
                $command = new OwnAdditionalBreedCommand(
                    new OwnerId($command->ownerId),
                    new BreedId($command->relatedModelId)
                );
                break;

            default:
                throw new InvalidArgumentException();
        }

        $commandHandler($command);
    }
}
