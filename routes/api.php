<?php

use App\Http\Controllers\Breed\GetAllBreedsController;
use App\Http\Controllers\Breed\GetBreedController;
use App\Http\Controllers\Breed\GetRandomBreedController;
use App\Http\Controllers\Breed\ShowBreedImageController;
use App\Http\Controllers\Park\AllowBreedController;
use App\Http\Controllers\Park\GetAllParksController;
use App\Http\Controllers\User\AssociateWithModelController;
use App\Http\Controllers\User\GetAllUsersController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/breed');
Route::get('/breed', [GetAllBreedsController::class, 'index']);
Route::get('/breed/random', [GetRandomBreedController::class, 'index']);
Route::get('/breed/{breedName}', [GetBreedController::class, 'index']);
Route::get('/breed/{breedName}/image', [ShowBreedImageController::class, 'index']);

Route::get('/users', [GetAllUsersController::class, 'index']);
Route::post('/user/{userId}/associate', [AssociateWithModelController::class, 'index']);

Route::get('/parks', [GetAllParksController::class, 'index']);
Route::post('/park/{parkId}/breed', [AllowBreedController::class, 'index']);
