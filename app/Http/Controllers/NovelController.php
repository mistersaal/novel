<?php

namespace App\Http\Controllers;

use App\Http\Resources\NovelResource;
use App\Models\Novel;

class NovelController extends Controller
{
    public function index(int $novel)
    {
        return new NovelResource(Novel::with(['author', 'cover'])->findOrFail($novel));
    }
}
