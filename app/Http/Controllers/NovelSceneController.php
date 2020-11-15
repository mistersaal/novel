<?php

namespace App\Http\Controllers;

use App\Exceptions\SceneException;
use App\Http\Requests\NextSceneRequest;
use App\Http\Resources\SceneResource;
use App\Models\Choice;
use App\Models\Novel;
use App\Models\User;
use App\Services\NovelActionsService;
use Illuminate\Support\Facades\Auth;

class NovelSceneController extends Controller
{
    private $novelService;

    public function __construct(NovelActionsService $novelService)
    {
        $this->novelService = $novelService;
        $this->middleware('auth:sanctum');
    }

    public function currentScene(Novel $novel)
    {
        $user = Auth::user();
        try {
            $scene = $this->novelService->getCurrentScene($user, $novel);
        } catch (SceneException $e) {
            abort(404, 'Новелла пока пуста');
        }
        return new SceneResource($scene);
    }

    public function toPreviousScene(Novel $novel)
    {
        $user = Auth::user();
        try {
            $previousScene = $this->novelService->toPreviousScene($user, $novel);
            return new SceneResource($previousScene);
        } catch (\Exception $e) {
            return abort(400, 'Невозможно произвести шаг назад');
        }
    }

    public function toNextScene(Novel $novel, NextSceneRequest $request)
    {
        $user = Auth::user();
        try {
            $choice = $request->choice ? Choice::findOrFail($request->choice) : null;
            $nextScene = $this->novelService->toNextScene($user, $novel, $choice);
            return new SceneResource($nextScene);
        } catch (\Exception $e) {
            return abort(400, 'Невозможно произвести шаг вперёд');
        }
    }
}
