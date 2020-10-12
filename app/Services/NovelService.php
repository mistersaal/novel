<?php


namespace App\Services;


use App\Models\Novel;
use App\Models\Scene;
use App\Models\User;

class NovelService
{
    private $sceneService;
    private $savingService;

    public function __construct(SceneService $sceneService, SavingService $savingService)
    {
        $this->sceneService = $sceneService;
        $this->savingService = $savingService;
    }

    /**
     * @param User $user
     * @param Novel $novel
     * @return Scene
     */
    public function getCurrentScene(User $user, Novel $novel): Scene
    {
        $save = $this->savingService->getSave($user, $novel);
        return $save->scene;
    }

    /**
     * @param User $user
     * @param Novel $novel
     * @return Scene
     * @throws \App\Exceptions\SceneException
     */
    public function toPreviousScene(User $user, Novel $novel): Scene
    {
        $save = $this->savingService->getSave($user, $novel);
        $previousScene = $this->sceneService->getPreviousScene($novel, $save->scene_id);
        $this->savingService->setScene($user, $novel, $previousScene, $save);
        return $previousScene;
    }
}
