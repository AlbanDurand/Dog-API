<?php

namespace App\Infrastructure\BreedExternalProvider;

use App\Domain\Breed\Breed;
use App\Domain\Breed\BreedExternalProvider\BreedExternalProviderInterface;
use App\Domain\Breed\BreedSummary;
use App\Domain\Breed\BreedSummaryList;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

final readonly class BreedApiProvider implements BreedExternalProviderInterface
{
    public function __construct(private string $baseUrl)
    {}

    public function fetchAll(): BreedSummaryList
    {
        $breedSummaries = collect($this->fetch('/breeds/list'))
            ->map(fn (string $breedName) => new BreedSummary($breedName))
            ->toArray();

        return new BreedSummaryList(...$breedSummaries);
    }

    public function fetchOneByName(string $breedName): Breed
    {
        return new Breed(
            $breedName,
            $this->fetch('/breed/' . $breedName . '/images')
        );
    }

    public function fetchOneRandomly(): Breed
    {
        return $this->fetchOneByName($this->fetch('/breeds/list/random'));
    }

    private function fetch(string $urlPath): mixed
    {
        $response = Http::get($this->buildUrl($urlPath));

        return Arr::get($response->json(), 'message');
    }

    private function buildUrl(string $urlPath): string
    {
        return rtrim($this->baseUrl, '/') . '/' . ltrim($urlPath, '/');
    }
}
