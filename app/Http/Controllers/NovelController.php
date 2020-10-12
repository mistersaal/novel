<?php

namespace App\Http\Controllers;

use App\Http\Resources\NovelResource;
use App\Http\Resources\SceneResource;
use App\Models\Novel;
use App\Models\Save;
use App\Models\Scene;
use App\Models\User;
use App\Services\SavingService;

class NovelController extends Controller
{
    public function index(int $novel)
    {
        return new NovelResource(Novel::with(['author', 'cover'])->findOrFail($novel));
    }

    public function currentScene(Novel $novel, SavingService $savingService)
    {
        /** @var User $user пока заглушка без аутентификации */
        $user = User::first();
        $save = $savingService->getSave($user, $novel);
        return new SceneResource($save->scene()->with(['image', 'music', 'choices'])->firstOrFail());
    }
}
