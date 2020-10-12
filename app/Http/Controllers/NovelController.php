<?php

namespace App\Http\Controllers;

use App\Http\Resources\NovelResource;
use App\Http\Resources\SceneResource;
use App\Models\Novel;
use App\Models\User;
use App\Services\NovelService;

class NovelController extends Controller
{
    private $novelService;

    public function __construct(NovelService $novelService)
    {
        $this->novelService = $novelService;
    }

    public function index(Novel $novel)
    {
        $novel->load(['author', 'cover']);
        return new NovelResource($novel);
    }

    public function currentScene(Novel $novel)
    {
        /** @var User $user пока заглушка без аутентификации */
        $user = User::first();
        $scene = $this->novelService->getCurrentScene($user, $novel);
        return new SceneResource($scene);
    }

    public function toPreviousScene(Novel $novel)
    {
        /** @var User $user пока заглушка без аутентификации */
        $user = User::first();
        try {
            $previousScene = $this->novelService->toPreviousScene($user, $novel);
            return new SceneResource($previousScene);
        } catch (\Exception $e) {
            return abort(400, 'Невозможно произвести шаг назад');
        }
    }
}
