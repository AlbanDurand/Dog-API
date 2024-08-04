<?php

namespace App\Http\Controllers\Park;

use App\Domain\Breed\BreedId;
use App\Domain\Park\AllowBreed\AllowBreedCommand;
use App\Domain\Park\AllowBreed\AllowBreedInterface;
use App\Domain\Park\ParkId;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AllowBreedController extends Controller
{
    public function index(
        Request $request,
        AllowBreedInterface $allowBreed,
        string $parkId
    ) {
        $allowBreed(
            new AllowBreedCommand(
                new ParkId($parkId),
                new BreedId($request->json('breedId'))
            )
        );

        return response(status: 204);
    }
}
