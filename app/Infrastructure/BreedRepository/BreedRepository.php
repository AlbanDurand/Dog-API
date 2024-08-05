<?php

namespace App\Infrastructure\BreedRepository;

use App\Domain\Breed\AvailablePark;
use App\Domain\Breed\Breed;
use App\Domain\Breed\BreedId;
use App\Domain\Breed\BreedOwner;
use App\Domain\Breed\BreedRepositoryInterface;
use App\Domain\Breed\BreedSummary;
use App\Domain\Breed\BreedSummaryList;
use App\Domain\Breed\SubBreed;
use App\Domain\Owner\OwnerId;
use App\Domain\Park\ParkId;
use App\Domain\Shared\Email\Email;
use App\Models\Breed as BreedModel;
use App\Models\Image;
use App\Models\Park;
use App\Models\SubBreed as SubBreedModel;
use App\Models\User;
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
                $breedModel->subBreeds->map(fn (SubBreedModel $model) => new SubBreed($model->name))->toArray(),
                $breedModel->images->map(fn (Image $image): string => $image->path)->toArray(),
                $breedModel->users
                    ->map(function (User $user): BreedOwner {
                        return new BreedOwner(
                            new OwnerId($user->id),
                            new Email($user->email),
                            $user->name,
                            $user->location
                        );
                    })->toArray(),
                $breedModel->parks
                    ->map(function (Park $park): AvailablePark {
                        return new AvailablePark(new ParkId($park->id), $park->name);
                    })
                    ->toArray()
            )
            : null;
    }

    public function saveOne(Breed $breed): void
    {
        /** @var BreedModel $breedModel */
        $breedModel = BreedModel::updateOrCreate(['name' => $breed->name]);

        $this->syncBreedImages($breedModel, $breed->imagePaths);
        $this->syncSubBreedsOfBreed($breedModel, $breed->subBreeds);
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

    /**
     * @param array<SubBreed> $subBreeds
     */
    private function syncSubBreedsOfBreed(BreedModel $breedModel, array $subBreeds): void
    {
        foreach ($subBreeds as $subBreed) {
            SubBreedModel::updateOrCreate(['name' => $subBreed->name]);
        }

        $subBreedNames = array_map(
            fn (SubBreed $subBreed): string => $subBreed->name,
            $subBreeds
        );

        $breedModel->subBreeds()->sync($subBreedNames);
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
