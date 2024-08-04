<?php

namespace Tests\Application\Breed\SynchronizeBreedSummaryList;

use App\Application\Breed\SynchronizeBreedSummaryList\SynchronizeBreedSummaryList;
use App\Domain\Breed\BreedSummary;
use App\Domain\Breed\BreedSummaryList;
use App\Infrastructure\BreedRepository\BreedRepository;
use App\Infrastructure\BreedSummaryListSynchronizationRepository\BreedSummaryListSynchronizationRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\Clock\Clock;
use Tests\Double\InMemoryBreedExternalProvider;
use Tests\TestCase;

class SynchronizeBreedSummaryListTest extends TestCase
{
    use RefreshDatabase;

    public function testBreedsAreSynchronized(): void
    {
        $externalProvider = new InMemoryBreedExternalProvider([
            new BreedSummary('australian'),
            new BreedSummary('husky'),
            new BreedSummary('labrador')
        ]);

        $breedRepository = new BreedRepository();

        $synchronize = new SynchronizeBreedSummaryList(
            $externalProvider,
            $breedRepository,
            new BreedSummaryListSynchronizationRepository(),
            new Clock()
        );

        $breedRepository->saveMany(
            new BreedSummaryList(
                new BreedSummary('doberman'),
                new BreedSummary('labrador'),
            )
        );

        self::assertEquals(
            new BreedSummaryList(
                new BreedSummary('doberman'),
                new BreedSummary('labrador'),
            ),
            $breedRepository->getAll()
        );

        $synchronize();

        self::assertEquals(
            new BreedSummaryList(
                new BreedSummary('australian'),
                new BreedSummary('husky'),
                new BreedSummary('labrador')
            ),
            $breedRepository->getAll()
        );
    }
}
