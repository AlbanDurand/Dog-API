<?php

namespace App\Infrastructure\OwnerRepository;

use App\Domain\Breed\BreedId;
use App\Domain\Owner\Owner;
use App\Domain\Owner\OwnerId;
use App\Domain\Owner\OwnerRepositoryInterface;
use App\Domain\Park\ParkId;
use App\Domain\Shared\Email\Email;
use App\Models\User;

final readonly class OwnerRepository implements OwnerRepositoryInterface
{
    public function save(Owner $owner): void
    {
        /** @var User $user */
        $user = User::updateOrCreate(
            ['id' => $owner->id->value],
            ['name' => $owner->name(), 'email' => $owner->email()->value, 'location' => $owner->location()]
        );

        $ownedBreedIds = collect($owner->ownedBreeds())->pluck('value')->toArray();
        $user->breeds()->sync($ownedBreedIds);

        $attendedParks = collect($owner->attendedParks())->pluck('value')->toArray();
        $user->parks()->sync($attendedParks);
    }

    /**
     * @return array<Owner>
     */
    public function getAll(): array
    {
        $users = User::orderBy('name')->get();

        return array_map([$this, 'mapFromUser'], $users);
    }

    public function findOne(OwnerId $id): ?Owner
    {
        /** @var User|null $user */
        $user = User::find($id->value);

        return $user === null ? null : $this->mapFromUser($user);

    }

    private function mapFromUser(User $user): Owner
    {
        $owner = new Owner(new OwnerId($user->id), new Email($user->email), $user->name, $user->location);

        /** @var array<BreedId> $ownedBreeds */
        $ownedBreeds = $user->breeds->pluck('name')->map(fn (string $id) => new BreedId($id));
        $owner->ownBreeds(...$ownedBreeds);

        /** @var array<ParkId> $attendedParks */
        $attendedParks = $user->parks->pluck('id')->map(fn (string $id) => new ParkId($id));
        $owner->attendParks(...$attendedParks);

        return $owner;
    }
}
