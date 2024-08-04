<?php

namespace Tests\Domain\Park;

use App\Domain\Breed\Breed;
use App\Domain\Breed\BreedId;
use App\Domain\Breed\BreedSummary;
use App\Domain\Breed\BreedSummaryList;
use App\Domain\Park\Park;
use App\Domain\Park\ParkId;
use Tests\TestCase;

class ParkTest extends TestCase
{
    public function testParkAllowsNewBreeds(): void
    {
        $park = new Park(new ParkId('1'), 'Hyde Park');

        $park->allowBreeds(
            new BreedId('Eskimo'),
            new BreedId('Labrador')
        );

        $park->allowAdditionalBreed(new BreedId('Husky'));

        self::assertCount(3, $park->allowedBreeds());
        self::assertContainsEquals(new BreedId('Eskimo'), $park->allowedBreeds());
        self::assertContainsEquals(new BreedId('Labrador'), $park->allowedBreeds());
        self::assertContainsEquals(new BreedId('Husky'), $park->allowedBreeds());
    }
}
