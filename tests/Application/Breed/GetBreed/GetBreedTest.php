<?php

namespace Tests\Application\Breed\GetBreed;

use App\Application\Breed\BreedDto;
use App\Application\Breed\GetBreed\GetBreed;
use App\Application\Breed\GetBreed\GetBreedQuery;
use App\Application\Owner\OwnAdditionalBreed\OwnAdditionalBreed;
use App\Domain\Breed\Breed;
use App\Domain\Breed\BreedId;
use App\Domain\Owner\Owner;
use App\Domain\Owner\OwnerId;
use App\Domain\Park\Park;
use App\Domain\Park\ParkId;
use App\Domain\Shared\Email\Email;
use App\Infrastructure\BreedRepository\BreedRepository;
use App\Infrastructure\OwnerRepository\OwnerRepository;
use App\Infrastructure\ParkRepository\ParkRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Double\DummySynchronizeBreed;
use Tests\TestCase;

class GetBreedTest extends TestCase
{
    use RefreshDatabase;

    public function testGetBreedDto()
    {
        // Arrange
        $breedRepository = new BreedRepository();
        $breedRepository->saveOne(new Breed('husky'));

        $owner = new Owner(new OwnerId('1'), new Email('fake@email.com'), 'Fake name', 'Fake location');
        $owner->ownBreeds(new BreedId('husky'));

        $ownerRepository = new OwnerRepository();
        $ownerRepository->save($owner);

        $park = new Park(new ParkId('15'), 'Hyde Park');
        $park->allowBreeds(new BreedId('husky'));

        $parkRepository = new ParkRepository();
        $parkRepository->save($park);

        // Act
        $getBreed = new GetBreed(new DummySynchronizeBreed(), $breedRepository);
        $breedDto = $getBreed(new GetBreedQuery('husky'));

        // Assert
        self::assertEquals(
            new BreedDto(
                'husky',
                [],
                [],
                [
                    [
                        'id' => '1',
                        'email' => 'fake@email.com',
                        'name' => 'Fake name',
                        'location' => 'Fake location',
                    ]
                ],
                [
                    [
                        'id' => '15',
                        'name' => 'Hyde Park',
                    ]
                ]
            ),
            $breedDto
        );
    }
}
