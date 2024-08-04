<?php

namespace App\Http\Controllers\Park;

use App\Domain\Park\Park;
use App\Domain\Park\ParkRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GetAllParksController extends Controller
{
    public function index(ParkRepositoryInterface $parkRepository)
    {
        return response()->json(array_map(function (Park $park) {
            return [
                'id' => $park->id->value,
                'name' => $park->name()
            ];
        }, $parkRepository->getAll()));
    }
}
