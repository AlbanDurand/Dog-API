<?php

namespace Tests\Infrastructure\OwnerRepository;

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

class OwnerRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testOwnerIsCorrectlyCreatedInDatabase()
    {
        // Arrange
        Breed::create(['name' => 'Breed 1']);
        Breed::create(['name' => 'Breed 2']);
        Breed::create(['name' => 'Breed 3']);

        Park::create(['id' => '1', 'name' => 'Park 1']);
        Park::create(['id' => '2', 'name' => 'Park 2']);

        // Act
        $owner = new Owner(new OwnerId('fakeId'), new Email('fake@email.com'), 'Fake name', 'Fake location');
        $owner->ownBreeds(new BreedId('Breed 2'), new BreedId('Breed 3'));
        $owner->attendParks(new ParkId('1'));

        $repository = new OwnerRepository();
        $repository->save($owner);

        // Assert
        $expectedOwner = new Owner(new OwnerId('fakeId'), new Email('fake@email.com'), 'Fake name', 'Fake location');
        $expectedOwner->ownBreeds(new BreedId('Breed 2'), new BreedId('Breed 3'));
        $expectedOwner->attendParks(new ParkId('1'));

        $savedOwner = $repository->findOne(new OwnerId('fakeId'));

        self::assertEquals($savedOwner, $expectedOwner);
    }

    public function testOwnerIsCorrectlyUpdatedInDatabase(): void
    {
        // Arrange
        Breed::create(['name' => 'Breed 1']);
        Breed::create(['name' => 'Breed 2']);
        Breed::create(['name' => 'Breed 3']);

        Park::create(['id' => '1', 'name' => 'Park 1']);
        Park::create(['id' => '2', 'name' => 'Park 2']);

        $owner = new Owner(new OwnerId('fakeId'), new Email('fake@email.com'), 'Fake name', 'Fake location');
        $owner->ownBreeds(new BreedId('Breed 2'), new BreedId('Breed 3'));
        $owner->attendParks(new ParkId('1'));

        $repository = new OwnerRepository();
        $repository->save($owner);

        // Act
        $owner->ownBreeds(new BreedId('Breed 1'));
        $owner->attendParks();
        $repository->save($owner);

        // Assert
        $expectedOwner = new Owner(new OwnerId('fakeId'), new Email('fake@email.com'), 'Fake name', 'Fake location');
        $expectedOwner->ownBreeds(new BreedId('Breed 1'));
        $expectedOwner->attendParks();

        $savedOwner = $repository->findOne(new OwnerId('fakeId'));

        self::assertEquals($savedOwner, $expectedOwner);
    }
}
