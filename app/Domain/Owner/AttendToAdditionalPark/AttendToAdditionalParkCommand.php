<?php

namespace App\Domain\Owner\AttendToAdditionalPark;

use App\Domain\Owner\OwnerId;
use App\Domain\Park\ParkId;

final readonly class AttendToAdditionalParkCommand
{
    public function __construct(
        public OwnerId $ownerId,
        public ParkId $parkId
    ) {}
}
