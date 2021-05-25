<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNovelRequest;
use App\Http\Requests\PatchNovelRequest;
use App\Http\Resources\NovelResource;
use App\Models\User;
use App\Models\Novel;
use Illuminate\Support\Facades\Auth;

class NovelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'all']]);
        $this->middleware('verified', ['except' => ['index', 'all']]);
    }

    public function index(Novel $novel)
    {
        $this->authorize('get', $novel);

        return new NovelResource($novel->load('author'));
    }

    public function all()
    {
        if (!Auth::guest() && Auth::user()->is_admin) {
            $novels = Novel::with('author')->get();
        } else {
            $novels = Novel::with('author')->where('is_banned', '=', false)->get();
            $novels->reject(function ($novel) {
                return $novel->author->is_banned;
            });
        }

        return NovelResource::collection($novels);
    }

    public function create(CreateNovelRequest $request)
    {
        $this->authorize('create', Novel::class);

        $user = Auth::user();
        $novel = $user->novels()->create($request->validated());

        return new NovelResource($novel);
    }

    public function patch(Novel $novel, PatchNovelRequest $request)
    {
        $this->authorize('update', $novel);

        $novel->update($request->validated());

        return new NovelResource($novel);
    }
}
