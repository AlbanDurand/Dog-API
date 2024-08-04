<?php

namespace Tests\Http\Controllers\User;

use App\Domain\Breed\BreedId;
use App\Domain\Owner\Owner;
use App\Domain\Owner\OwnerId;
use App\Domain\Park\ParkId;
use App\Domain\Shared\Email\Email;
use App\Infrastructure\OwnerRepository\OwnerRepository;
use App\Models\Breed;
use App\Models\Park;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssociateWithModelControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testOwnerIsAssociatedWithPark()
    {
        // Arrange
        $ownerRepository = new OwnerRepository();
        $owner = new Owner(new OwnerId('owner1'), new Email('fake@email.com'), 'Fake name', 'Fake location');
        $ownerRepository->save($owner);

        Park::create(['id' => '1', 'name' => 'Park 1']);

        // Act
        $this->postJson('/user/owner1/associate', [
           'relatedModelType' => 'park',
           'relatedModelId' => '1'
        ]);

        // Assert
        $savedOwner = $ownerRepository->findOne(new OwnerId('owner1'));
        $expectedOwner = new Owner(new OwnerId('owner1'), new Email('fake@email.com'), 'Fake name', 'Fake location');
        $expectedOwner->attendParks(new ParkId('1'));

        self::assertEquals($expectedOwner, $savedOwner);
    }

    public function testOwnerIsAssociatedWithBreed()
    {
        // Arrange
        $ownerRepository = new OwnerRepository();
        $owner = new Owner(new OwnerId('owner1'), new Email('fake@email.com'), 'Fake name', 'Fake location');
        $ownerRepository->save($owner);

        Breed::create(['name' => 'Labrador']);

        // Act
        $this->postJson('/user/owner1/associate', [
            'relatedModelType' => 'breed',
            'relatedModelId' => 'Labrador'
        ]);

        // Assert
        $savedOwner = $ownerRepository->findOne(new OwnerId('owner1'));
        $expectedOwner = new Owner(new OwnerId('owner1'), new Email('fake@email.com'), 'Fake name', 'Fake location');
        $expectedOwner->ownBreeds(new BreedId('Labrador'));

        self::assertEquals($expectedOwner, $savedOwner);
    }
}
