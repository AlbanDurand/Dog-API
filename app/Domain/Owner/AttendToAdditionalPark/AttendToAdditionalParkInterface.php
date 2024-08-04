<?php

namespace App\Domain\Owner\AttendToAdditionalPark;

use App\Domain\Owner\NotFoundOwnerException;

interface AttendToAdditionalParkInterface
{
    /**
     * @throws NotFoundOwnerException
     */
    public function __invoke(AttendToAdditionalParkCommand $command): void;
}
