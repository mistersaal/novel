<?php


namespace App\Services;


use App\Models\Novel;
use App\Models\Save;
use App\Models\User;

class SavingService
{
    public function getSave(User $user, Novel $novel): Save
    {
        if (!$save = $user->saves()->whereNovelId($novel->id)->first()) {
            $save = new Save();
            $save->novel()->associate($novel);
            $save->scene()->associate($novel->firstScene);
            $user->saves()->save($save);
        }
        return $save;
    }
}
