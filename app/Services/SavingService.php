<?php


namespace App\Services;


use App\Exceptions\SceneException;
use App\Models\Novel;
use App\Models\Save;
use App\Models\Scene;
use App\Models\User;

class SavingService
{
    /**
     * @param User $user
     * @param Novel $novel
     * @return Save
     * @throws SceneException
     */
    public function getSave(User $user, Novel $novel): Save
    {
        if (!$save = $this->getUserNovelSave($user, $novel)) {
            if (!$novel->first_scene_id) {
                throw new SceneException("Novel is empty");
            }
            $save = new Save();
            $save->novel()->associate($novel);
            $save->scene()->associate($novel->firstScene);
            $user->saves()->save($save);
        }
        return $save;
    }

    public function setScene(User $user, Novel $novel, Scene $scene, Save $save = null): void
    {
        $save = $save ? $save : $this->getSave($user, $novel);
        $save->scene()->associate($scene);
        $save->save();
    }

    private function getUserNovelSave(User $user, Novel $novel): ?Save
    {
        return $user->saves()->whereNovelId($novel->id)->first();
    }
}
