<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    use HasFactory;

    protected $fillable = [
        'scene_id',
        'next_scene_id',
        'value',
    ];

    public function scene()
    {
        return $this->belongsTo(Scene::class);
    }

    public function nextScene()
    {
        return $this->belongsTo(Scene::class, 'next_scene_id');
    }
}
