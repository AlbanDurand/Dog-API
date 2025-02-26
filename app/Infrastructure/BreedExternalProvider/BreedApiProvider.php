<?php

namespace App\Infrastructure\BreedExternalProvider;

use App\Domain\Breed\Breed;
use App\Domain\Breed\BreedExternalProvider\BreedExternalProviderInterface;
use App\Domain\Breed\BreedSummary;
use App\Domain\Breed\BreedSummaryList;
use App\Domain\Breed\NotFoundBreedException;
use App\Domain\Breed\SubBreed;
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

    /**
     * @throws NotFoundBreedException
     */
    public function fetchOneByName(string $breedName): Breed
    {
        try {
            /** @var array<SubBreed> $subBreeds */
            $subBreeds = array_map(
                fn (string $subBreedName): SubBreed => new SubBreed($subBreedName),
                $this->fetch('/breed/' . $breedName . '/list')
            );

            /** @var array<string> $images */
            $images = $this->fetch('/breed/' . $breedName . '/images');

            return new Breed($breedName, $subBreeds, $images);
        } catch (BreedApiProviderResponseException $e) {
            if ($e->httpStatus === 404) {
                throw new NotFoundBreedException($breedName);
            }

            throw $e;
        }
    }

    public function fetchOneRandomly(): Breed
    {
        return $this->fetchOneByName($this->fetch('/breeds/list/random'));
    }

    private function fetch(string $urlPath): mixed
    {
        $url = $this->buildUrl($urlPath);
        $response = Http::get($url);

        if ($response->failed()) {
            throw new BreedApiProviderResponseException($url, $response->status());
        }

        return Arr::get($response->json(), 'message');
    }

    private function buildUrl(string $urlPath): string
    {
        return rtrim($this->baseUrl, '/') . '/' . ltrim($urlPath, '/');
    }
}
