<?php

namespace App\Infrastructure\ParkRepository;

use App\Domain\Breed\BreedId;
use App\Domain\Park\Park;
use App\Domain\Park\ParkId;
use App\Domain\Park\ParkRepositoryInterface;
use App\Models\Park as ParkModel;

final readonly class ParkRepository implements ParkRepositoryInterface
{
    public function findOne(ParkId $id): ?Park
    {
        $model = ParkModel::find($id->value);

        return $model === null ? null : $this->mapFromModel($model);
    }

    public function save(Park $park): void
    {
        /** @var ParkModel $model */
        $model = ParkModel::updateOrCreate(
            ['id' => $park->id->value],
            ['name' => $park->name()]
        );

        $allowedBreedIds = collect($park->allowedBreeds())->pluck('value')->toArray();
        $model->breeds()->sync($allowedBreedIds);
    }

    private function mapFromModel(ParkModel $model): Park
    {
        $park = new Park(new ParkId($model->id), $model->name);

        /** @var array<BreedId> $ownedBreeds */
        $allowedBreeds = $model->breeds->pluck('name')->map(fn (string $id) => new BreedId($id));
        $park->allowBreeds(...$allowedBreeds);

        return $park;
    }
}
