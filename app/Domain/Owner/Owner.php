<?php

namespace App\Domain\Owner;

use App\Domain\Breed\BreedId;
use App\Domain\Park\ParkId;
use App\Domain\Shared\Email\Email;

final class Owner
{
    /** @var array<BreedId> */
    private array $ownedBreeds;

    /** @var array<ParkId> */
    private array $attendedParks;

    public function __construct(
        public readonly OwnerId $id,
        private Email $email,
        private string $name,
        private string $location
    ) {
        $this->ownedBreeds = [];
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function location(): string
    {
        return $this->location;
    }

    /**
     * @return array<BreedId>
     */
    public function ownedBreeds(): array
    {
        return $this->ownedBreeds;
    }

    public function ownBreeds(BreedId ...$ownedBreeds): void
    {
        $this->ownedBreeds = array_unique($ownedBreeds, SORT_REGULAR);
    }

    public function ownAdditionalBreed(BreedId $breed): void
    {
        if (!in_array($breed, $this->ownedBreeds, true)) {
            $this->ownedBreeds[] = $breed;
        }
    }

    /**
     * @return array<ParkId>
     */
    public function attendedParks(): array
    {
        return $this->attendedParks;
    }

    public function attendParks(ParkId ...$parkIds): void
    {
        $this->attendedParks = array_unique($parkIds, SORT_REGULAR);
    }

    public function attendAdditionalPark(ParkId $parkId): void
    {
        if ($this->canAttendPark($parkId) === false) {
            $this->attendedParks[] = $parkId;
        }
    }

    public function canAttendPark(ParkId $parkId): bool
    {
        return in_array($parkId, $this->attendedParks);
    }
}
