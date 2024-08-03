<?php

namespace App\Http\Controllers\Breed;

use App\Application\Breed\GetAllBreeds\GetAllBreedsInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class GetAllBreedsController extends Controller
{
    public function index(GetAllBreedsInterface $getAllBreeds): JsonResponse
    {
        return response()->json($getAllBreeds());
    }
}
