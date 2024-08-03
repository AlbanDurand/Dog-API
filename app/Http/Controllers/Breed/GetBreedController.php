<?php

namespace App\Http\Controllers\Breed;

use App\Application\Breed\GetBreed\GetBreedInterface;
use App\Application\Breed\GetBreed\GetBreedQuery;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class GetBreedController extends Controller
{
    public function index(GetBreedInterface $getBreed, string $breedName): JsonResponse
    {
        return response()->json($getBreed(new GetBreedQuery($breedName)));
    }
}
