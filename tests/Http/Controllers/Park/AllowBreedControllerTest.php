<?php

namespace Tests\Http\Controllers\Park;

use App\Domain\Breed\BreedId;
use App\Domain\Owner\Owner;
use App\Domain\Owner\OwnerId;
use App\Domain\Park\Park;
use App\Domain\Park\ParkId;
use App\Domain\Shared\Email\Email;
use App\Infrastructure\ParkRepository\ParkRepository;
use App\Models\Breed as BreedModel;
use App\Models\Park as ParkModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AllowBreedControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testBreedIsAllowedInPark(): void
    {
        ParkModel::create(['id' => '1', 'name' => 'Park 1']);
        BreedModel::create(['name' => 'staffordshire']);

        $this->postJson('/park/1/breed', [
            'breedId' => 'staffordshire'
        ]);

        $parkRepository = new ParkRepository();
        $savedPark = $parkRepository->findOne(new ParkId('1'));
        $expectedPark = new Park(new ParkId('1'), 'Park 1');
        $expectedPark->allowBreeds(new BreedId('staffordshire'));

        self::assertEquals($expectedPark, $savedPark);
    }
}
