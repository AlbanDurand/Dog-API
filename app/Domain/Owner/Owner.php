<?php

namespace App\Domain\Owner;

use App\Domain\Breed\Breed;
use App\Domain\Breed\BreedId;
use App\Domain\Breed\BreedSummary;
use App\Domain\Breed\BreedSummaryList;
use App\Domain\Shared\Email\Email;

final class Owner
{
    private BreedSummaryList $ownedBreeds;

    public function __construct(
        public readonly OwnerId $id,
        private Email $email,
        private string $name,
        private string $location
    ) {
        $this->ownedBreeds = new BreedSummaryList();
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

    public function ownedBreeds(): BreedSummaryList
    {
        return $this->ownedBreeds;
    }

    public function ownBreeds(BreedSummaryList $ownedBreeds): void
    {
        $this->ownedBreeds = $ownedBreeds;
    }

    public function ownNewBreed(BreedSummary|Breed|BreedId $breed): void
    {
        $breedSummary = match (true) {
            $breed instanceof BreedId => new BreedSummary($breed->value),
            $breed instanceof Breed => new BreedSummary($breed->name),
            default => $breed,
        };

        /** @var BreedSummary $breedSummary */
        foreach ($this->ownedBreeds as $ownedBreedSummary) {
            if ($ownedBreedSummary->name === $breedSummary->name) {
                return;
            }
        }

        $this->ownedBreeds = new BreedSummaryList(
            $breedSummary, ...$this->ownedBreeds->items
        );
    }
}
