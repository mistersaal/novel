<?php


namespace App\Services;


use App\Exceptions\SceneException;
use App\Models\Choice;
use App\Models\Novel;
use App\Models\Scene;

class SceneService
{
    /**
     * @param Novel $novel
     * @param int|Scene $currentScene
     * @return Scene
     * @throws SceneException
     */
    public function getPreviousScene(Novel $novel, $currentScene): Scene
    {
        $currentSceneId = $currentScene instanceof Scene ? $currentScene->id : $currentScene;
        if ($currentSceneId === $novel->first_scene_id ||
            !$previousScene = Scene::whereNextSceneId($currentSceneId)->first() ??
                Choice::whereNextSceneId($currentSceneId)->first()->scene
        ) {
            throw new SceneException('Cannot find previous scene for first scene');
        }
        return $previousScene;
    }
}
