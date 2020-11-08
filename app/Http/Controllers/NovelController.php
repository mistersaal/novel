<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNovelRequest;
use App\Http\Resources\NovelResource;
use App\Models\User;
use App\Models\Novel;

class NovelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'all']]);
    }

    public function index(Novel $novel)
    {
        return new NovelResource($novel->load('author'));
    }

    public function all()
    {
        return NovelResource::collection(Novel::with('author')->get());
    }

    public function create(CreateNovelRequest $request)
    {
        /** @var User $user */
        $user = auth()->user();
        $novel = $user->novels()->create($request->validated());
        return new NovelResource($novel);
    }
}
