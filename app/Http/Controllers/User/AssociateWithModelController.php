<?php

namespace App\Http\Controllers\User;

use App\Application\Owner\AssociateWithModel\AssociateWithModelCommand;
use App\Application\Owner\AssociateWithModel\AssociateWithModelInterface;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AssociateWithModelController extends Controller
{
    public function index(
        AssociateWithModelInterface $associateWithModel,
        Request $request,
        string $userId
    ): Application|Response|ResponseFactory {
        $associateWithModel(
            new AssociateWithModelCommand(
                $userId,
                $request->json('relatedModelType'),
                $request->json('relatedModelId'),
            )
        );

        return response(status: 204);
    }
}
