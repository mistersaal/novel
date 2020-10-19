<?php

namespace App\Http\Controllers;

use App\Http\Requests\NextSceneRequest;
use App\Http\Resources\NovelResource;
use App\Http\Resources\SceneResource;
use App\Models\Choice;
use App\Models\Novel;
use App\Models\User;
use App\Services\NovelService;

class NovelController extends Controller
{
    private $novelService;

    public function __construct(NovelService $novelService)
    {
        $this->novelService = $novelService;
        $this->middleware('auth:sanctum');
    }

    public function index(Novel $novel)
    {
        return new NovelResource($novel->load('author'));
    }

    public function currentScene(Novel $novel)
    {
        /** @var User $user */
        $user = auth()->user();
        $scene = $this->novelService->getCurrentScene($user, $novel);
        return new SceneResource($scene);
    }

    public function toPreviousScene(Novel $novel)
    {
        /** @var User $user */
        $user = auth()->user();
        try {
            $previousScene = $this->novelService->toPreviousScene($user, $novel);
            return new SceneResource($previousScene);
        } catch (\Exception $e) {
            return abort(400, 'Невозможно произвести шаг назад');
        }
    }

    public function toNextScene(Novel $novel, NextSceneRequest $request)
    {
        /** @var User $user */
        $user = auth()->user();
        try {
            $choice = $request->choice ? Choice::findOrFail($request->choice) : null;
            $nextScene = $this->novelService->toNextScene($user, $novel, $choice);
            return new SceneResource($nextScene);
        } catch (\Exception $e) {
            return abort(400, 'Невозможно произвести шаг вперёд');
        }
    }
}
