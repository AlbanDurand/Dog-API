<?php

namespace App\Http\Controllers\Breed;

use App\Application\Breed\GetRandomBreed\GetRandomBreedInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class GetRandomBreedController extends Controller
{
    public function index(GetRandomBreedInterface $getRandomBreed): JsonResponse
    {
        return response()->json($getRandomBreed());
    }
}
