<?php


namespace App\Services;


use App\Models\Choice;
use App\Models\Novel;
use App\Models\Scene;
use App\Models\User;

class NovelActionsService
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

    /**
     * @param User $user
     * @param Novel $novel
     * @param Choice|null $choice
     * @return Scene
     * @throws \App\Exceptions\SceneException
     */
    public function toNextScene(User $user, Novel $novel, Choice $choice = null): Scene
    {
        $save = $this->savingService->getSave($user, $novel);
        $nextScene = $this->sceneService->getNextScene($save->scene, $choice);
        $this->savingService->setScene($user, $novel, $nextScene, $save);
        return $nextScene;
    }
}
