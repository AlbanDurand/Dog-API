<?php

namespace Tests\Application\Owner\AttendToAdditionalPark;

use App\Application\Owner\AttendToAdditionalPark\AttendToAdditionalPark;
use App\Domain\Owner\AttendToAdditionalPark\AttendToAdditionalParkCommand;
use App\Domain\Owner\Owner;
use App\Domain\Owner\OwnerId;
use App\Domain\Park\Park;
use App\Domain\Park\ParkId;
use App\Domain\Shared\Email\Email;
use App\Infrastructure\OwnerRepository\OwnerRepository;
use App\Infrastructure\ParkRepository\ParkRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendToAdditionalParkTest extends TestCase
{
    use RefreshDatabase;

    public function testOwnerAttendsAdditionalPark()
    {
        // Arrange
        $ownerRepository = new OwnerRepository();
        $owner = new Owner(new OwnerId('owner1'), new Email('fake@email.com'), 'Fake name', 'Fake location');
        $ownerRepository->save($owner);

        $parkRepository = new ParkRepository();
        $park = new Park(new ParkId('park1'), 'Park 1');
        $parkRepository->save($park);

        // Act
        $attendToAdditionalPark = new AttendToAdditionalPark($ownerRepository);
        $attendToAdditionalPark(
            new AttendToAdditionalParkCommand(
                new OwnerId('owner1'),
                new ParkId('park1')
            )
        );

        // Assert
        $savedOwner = $ownerRepository->findOne(new OwnerId('owner1'));
        $expectedOwner = new Owner(new OwnerId('owner1'), new Email('fake@email.com'), 'Fake name', 'Fake location');
        $expectedOwner->attendParks(new ParkId('park1'));

        self::assertEquals($expectedOwner, $savedOwner);
    }
}
