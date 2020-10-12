<?php


namespace App\Services;


use App\Models\Novel;
use App\Models\Save;
use App\Models\Scene;
use App\Models\User;

class SavingService
{
    public function getSave(User $user, Novel $novel): Save
    {
        if (!$save = $this->getUserNovelSave($user, $novel)) {
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
