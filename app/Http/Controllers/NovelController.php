<?php

namespace App\Http\Controllers;

use App\Http\Resources\NovelResource;
use App\Http\Resources\SceneResource;
use App\Models\Novel;
use App\Models\User;
use App\Services\SavingService;

class NovelController extends Controller
{
    public function index(Novel $novel)
    {
        $novel->load(['author', 'cover']);
        return new NovelResource($novel);
    }

    public function currentScene(Novel $novel, SavingService $savingService)
    {
        /** @var User $user пока заглушка без аутентификации */
        $user = User::first();
        $save = $savingService->getSave($user, $novel);
        return new SceneResource($save->scene);
    }
}
