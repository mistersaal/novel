<?php

namespace App\Http\Controllers;

use App\Models\Novel;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * AdminController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function blockUser(User $user)
    {
        $user->is_banned = true;
        $user->save();
    }

    public function unblockUser(User $user)
    {
        $user->is_banned = false;
        $user->save();
    }

    public function blockNovel(Novel $novel)
    {
        $novel->is_banned = true;
        $novel->save();
    }

    public function unblockNovel(Novel $novel)
    {
        $novel->is_banned = false;
        $novel->save();
    }
}
