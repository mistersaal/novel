<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
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
    public function get(Request $request)
    {
        return new UserResource($request->user());
    }

    /**
     * Редактирование пользователя
     *
     * @param Request $request
     * @return mixed|void
     */
    public function patch(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $user->name = $request->post('name');
        $user->save();

        return new UserResource($user);
    }
}
