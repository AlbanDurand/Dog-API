<?php

namespace App\Domain\Breed;

interface BreedRepositoryInterface
{
    public function getAll(): BreedSummaryList;

    public function findOne(BreedId $breedId): ?Breed;

    public function saveOne(Breed $breed): void;

    public function saveMany(BreedSummaryList $breedSummaryList): void;

    public function delete(BreedId ...$breedIds): void;
}
