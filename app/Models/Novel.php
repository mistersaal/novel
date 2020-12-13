<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Novel extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'image_id'];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function firstScene()
    {
        return $this->belongsTo(Scene::class, 'first_scene_id');
    }

    public function cover()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function music()
    {
        return $this->hasMany(Music::class);
    }

    public function saves()
    {
        return $this->hasMany(Save::class);
    }

    public function isAuthor(User $user)
    {
        return $user->id === $this->author_id;
    }

    public function scenes()
    {
        return $this->hasMany(Scene::class);
    }

    public function choices()
    {
        return $this->hasMany(Choice::class);
    }
}
