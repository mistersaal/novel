<?php

namespace App\Policies;

use App\Models\Novel;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NovelPolicy
{
    use HandlesAuthorization;

    public function get(User $user, Novel $novel)
    {
        return !$novel->is_banned || $user->is_admin || $novel->author_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Novel  $novel
     * @return mixed
     */
    public function update(User $user, Novel $novel)
    {
        return $novel->isAuthor($user);
    }
}
