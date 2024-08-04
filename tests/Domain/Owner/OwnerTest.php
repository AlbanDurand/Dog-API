<?php

namespace Tests\Domain\Owner;

use App\Domain\Owner\Owner;
use App\Domain\Owner\OwnerId;
use App\Domain\Park\ParkId;
use App\Domain\Shared\Email\Email;
use Tests\TestCase;

class OwnerTest extends TestCase
{
    public function testOwnerAttendsAdditionalPark(): void
    {
        $owner = new Owner(
            new OwnerId('1'),
            new Email('david.tennant@gmail.com'),
            'David Tennant',
            'London'
        );

        $owner->attendParks(new ParkId('1'), new ParkId('2'));

        $owner->attendAdditionalPark(new ParkId('3'));

        self::assertCount(3, $owner->attendedParks());
        self::assertContainsEquals(new ParkId('1'), $owner->attendedParks());
        self::assertContainsEquals(new ParkId('2'), $owner->attendedParks());
        self::assertContainsEquals(new ParkId('3'), $owner->attendedParks());
    }

    public function testOwnerAttendsDistinctParks()
    {
        $owner = new Owner(
            new OwnerId('1'),
            new Email('david.tennant@gmail.com'),
            'David Tennant',
            'London'
        );

        $owner->attendParks(new ParkId('1'), new ParkId('1'));
        $owner->attendAdditionalPark(new ParkId('1'));

        self::assertCount(1, $owner->attendedParks());
    }
}
