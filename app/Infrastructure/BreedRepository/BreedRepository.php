<?php

namespace App\Infrastructure\BreedRepository;

use App\Domain\Breed\Breed;
use App\Domain\Breed\BreedId;
use App\Domain\Breed\BreedRepositoryInterface;
use App\Domain\Breed\BreedSummary;
use App\Domain\Breed\BreedSummaryList;
use App\Models\Breed as BreedModel;
use App\Models\Image;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

final readonly class BreedRepository implements BreedRepositoryInterface
{
    public function getAll(): BreedSummaryList
    {
        /** @var Collection $breedModels */
        $breedModels = BreedModel::orderBy('name', 'asc')->get();

        $breedSummaries = $breedModels
            ->map(function (BreedModel $breedModel): BreedSummary {
                return new BreedSummary($breedModel->name);
            })
            ->toArray();

        return new BreedSummaryList(...$breedSummaries);
    }

    public function findOne(BreedId $breedId): ?Breed
    {
        /** @var BreedModel|null $breedModel */
        $breedModel = BreedModel::where('name', $breedId->value)->first();

        return $breedModel !== null
            ? new Breed(
                $breedModel->name,
                $breedModel->images->map(fn (Image $image): string => $image->path)->toArray()
            )
            : null;
    }

    public function saveOne(Breed $breed): void
    {
        /** @var BreedModel $breedModel */
        $breedModel = BreedModel::updateOrCreate(['name' => $breed->name]);

        $this->syncBreedImages($breedModel, $breed->imagePaths);
    }

    private function syncBreedImages(BreedModel $breedModel, array $imagePaths): void
    {
        if ($imagePaths === []) {
            return;
        }

        $imagePathsToAdd = collect($imagePaths)->diff($breedModel->images->pluck('path'));

        $breedModel->images()->whereNotIn('path', $imagePaths)->delete();

        $breedModel->images()->createMany(
            $imagePathsToAdd->map(fn (string $imagePath): array => ['path' => $imagePath])
        );
    }

    public function saveMany(BreedSummaryList $breedSummaryList): void
    {
        /** @var BreedSummary $breedSummary */
        foreach ($breedSummaryList as $breedSummary) {
            BreedModel::updateOrCreate(['name' => $breedSummary->name]);
        }
    }

    public function delete(BreedId ...$breedIds): void
    {
        BreedModel::destroy(
            Arr::map($breedIds, fn (BreedId $breedId) => $breedId->value)
        );
    }
}
