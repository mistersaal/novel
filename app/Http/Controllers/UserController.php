<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return UserResource
     */
    public function __invoke(Request $request)
    {
        return new UserResource($request->user());
    }
}
