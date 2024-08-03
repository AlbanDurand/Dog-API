<?php

namespace App\Http\Controllers\Breed;

use App\Application\Breed\FindBreedImagePath\FindBreedImagePathInterface;
use App\Application\Breed\FindBreedImagePath\FindBreedImagePathQuery;
use App\Http\Controllers\Controller;

class ShowBreedImageController extends Controller
{
    public function index(
        FindBreedImagePathInterface $findBreedImagePath,
        string $breedName
    ) {
        $imagePath = $findBreedImagePath(new FindBreedImagePathQuery($breedName));

        if ($imagePath === null) {
            return response(status: 404);
        }

        $image = file_get_contents($imagePath);

        return response($image)->header(
            'Content-Type',
            getimagesizefromstring($image)['mime']
        );
    }
}
