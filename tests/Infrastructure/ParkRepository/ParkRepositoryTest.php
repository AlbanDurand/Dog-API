<?php

namespace Tests\Infrastructure\ParkRepository;

use App\Domain\Breed\BreedId;
use App\Domain\Park\Park;
use App\Domain\Park\ParkId;
use App\Infrastructure\ParkRepository\ParkRepository;
use App\Models\Breed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParkRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testParkIsCorrectlyCreatedInDatabase(): void
    {
        // Arrange
        Breed::create(['name' => 'Breed 1']);
        Breed::create(['name' => 'Breed 2']);
        Breed::create(['name' => 'Breed 3']);

        $park = new Park(new ParkId('1'), 'Park 1');
        $park->allowBreeds(new BreedId('Breed 1'), new BreedId('Breed 2'));

        $repository = new ParkRepository();

        // Act
        $repository->save($park);

        // Assert
        $expectedPark = new Park(new ParkId('1'), 'Park 1');
        $expectedPark->allowBreeds(new BreedId('Breed 1'), new BreedId('Breed 2'));

        $savedPark = $repository->findOne(new ParkId('1'));

        self::assertEquals($expectedPark, $savedPark);
    }

    public function testParkIsCorrectlyUpdatedInDatabase(): void
    {
        // Arrange
        Breed::create(['name' => 'Breed 1']);
        Breed::create(['name' => 'Breed 2']);
        Breed::create(['name' => 'Breed 3']);

        $park = new Park(new ParkId('1'), 'Park 1');
        $park->allowBreeds(new BreedId('Breed 1'), new BreedId('Breed 2'));

        $repository = new ParkRepository();
        $repository->save($park);

        // Act
        $park->allowBreeds(new BreedId('Breed 3'));
        $repository->save($park);

        // Assert
        $expectedPark = new Park(new ParkId('1'), 'Park 1');
        $expectedPark->allowBreeds(new BreedId('Breed 3'));

        $savedPark = $repository->findOne(new ParkId('1'));

        self::assertEquals($expectedPark, $savedPark);
    }
}
