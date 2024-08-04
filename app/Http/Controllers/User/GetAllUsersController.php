<?php

namespace App\Http\Controllers\User;

use App\Domain\Owner\Owner;
use App\Domain\Owner\OwnerRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GetAllUsersController extends Controller
{
    public function index(OwnerRepositoryInterface $ownerRepository)
    {
        return response()->json(array_map(function (Owner $owner) {
            return [
                'id' => $owner->id->value,
                'name' => $owner->name(),
                'email' => $owner->email()->value,
                'location' => $owner->location()
            ];
        }, $ownerRepository->getAll()));
    }
}
