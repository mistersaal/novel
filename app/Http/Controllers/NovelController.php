<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNovelRequest;
use App\Http\Resources\NovelResource;
use App\Models\User;
use Illuminate\Http\Request;

class NovelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function create(CreateNovelRequest $request)
    {
        /** @var User $user */
        $user = auth()->user();
        $novel = $user->novels()->create($request->validated());
        return new NovelResource($novel);
    }
}
