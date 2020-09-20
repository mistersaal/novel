<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scene extends Model
{
    use HasFactory;

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function music()
    {
        return $this->belongsTo(Music::class);
    }

    public function nextScene()
    {
        return $this->belongsTo(Scene::class, 'next_scene_id');
    }

    public function choices()
    {
        return $this->hasMany(Choice::class);
    }
}
