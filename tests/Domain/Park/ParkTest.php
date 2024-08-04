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

        $park->allowBreeds(new BreedSummaryList(
            new BreedSummary('Eskimo'),
            new BreedSummary('Labrador')
        ));

        $park->allowNewBreed(new BreedId('Husky'));
        $park->allowNewBreed(new BreedSummary('Dalmatian'));
        $park->allowNewBreed(new Breed('Bluetick', []));

        self::assertCount(5, $park->allowedBreeds()->items);
        self::assertContainsEquals(new BreedSummary('Eskimo'), $park->allowedBreeds());
        self::assertContainsEquals(new BreedSummary('Labrador'), $park->allowedBreeds());
        self::assertContainsEquals(new BreedSummary('Husky'), $park->allowedBreeds());
        self::assertContainsEquals(new BreedSummary('Dalmatian'), $park->allowedBreeds());
        self::assertContainsEquals(new BreedSummary('Bluetick'), $park->allowedBreeds());
    }
}
