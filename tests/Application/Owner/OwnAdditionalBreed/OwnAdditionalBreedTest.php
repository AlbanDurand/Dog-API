<?php

namespace Tests\Application\Owner\OwnAdditionalBreed;

use App\Application\Owner\AttendToAdditionalPark\AttendToAdditionalPark;
use App\Application\Owner\OwnAdditionalBreed\OwnAdditionalBreed;
use App\Domain\Breed\BreedId;
use App\Domain\Owner\AttendToAdditionalPark\AttendToAdditionalParkCommand;
use App\Domain\Owner\OwnAdditionalBreed\OwnAdditionalBreedCommand;
use App\Domain\Owner\Owner;
use App\Domain\Owner\OwnerId;
use App\Domain\Park\Park;
use App\Domain\Park\ParkId;
use App\Domain\Shared\Email\Email;
use App\Infrastructure\BreedRepository\BreedRepository;
use App\Infrastructure\OwnerRepository\OwnerRepository;
use App\Infrastructure\ParkRepository\ParkRepository;
use App\Models\Breed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OwnAdditionalBreedTest extends TestCase
{
    use RefreshDatabase;

    public function testOwnerAttendsAdditionalPark()
    {
        // Arrange
        $ownerRepository = new OwnerRepository();
        $owner = new Owner(new OwnerId('owner1'), new Email('fake@email.com'), 'Fake name', 'Fake location');
        $ownerRepository->save($owner);

        Breed::create(['name' => 'Husky']);

        // Act
        $ownAdditionalBreed = new OwnAdditionalBreed($ownerRepository);
        $ownAdditionalBreed(
            new OwnAdditionalBreedCommand(
                new OwnerId('owner1'),
                new BreedId('Husky')
            )
        );

        // Assert
        $savedOwner = $ownerRepository->findOne(new OwnerId('owner1'));
        $expectedOwner = new Owner(new OwnerId('owner1'), new Email('fake@email.com'), 'Fake name', 'Fake location');
        $expectedOwner->ownBreeds(new BreedId('Husky'));

        self::assertEquals($expectedOwner, $savedOwner);
    }
}
