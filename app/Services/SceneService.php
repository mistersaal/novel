<?php


namespace App\Services;


use App\Exceptions\SceneException;
use App\Models\Choice;
use App\Models\Novel;
use App\Models\Scene;
use Illuminate\Database\Eloquent\Collection;

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
        $currentSceneId = $this->getSceneId($currentScene);
        if ($currentSceneId === $novel->first_scene_id ||
            !$previousScene = Scene::whereNextSceneId($currentSceneId)->first() ??
                Choice::whereNextSceneId($currentSceneId)->first()->scene
        ) {
            throw new SceneException('Cannot find previous scene for first scene');
        }
        return $previousScene;
    }

    /**
     * @param Novel $novel
     * @param Scene $currentScene
     * @param Choice|null $choice
     * @return Scene
     * @throws SceneException
     */
    public function getNextScene(Scene $currentScene, Choice $choice = null): Scene
    {
        if ($currentScene->next_scene_id) {
            return $currentScene->nextScene;
        }
        if (!$choice) {
            throw new SceneException('Cannot find next scene without choice');
        }
        if ($choice->scene_id !== $currentScene->id) {
            throw new SceneException('This choice id for another scene');
        }
        if (!$choice->next_scene_id) {
            throw new SceneException('Next scene does not exist');
        }
        return $choice->nextScene;
    }

    private function getSceneId($scene)
    {
        return $scene instanceof Scene ? $scene->id : $scene;
    }
}
