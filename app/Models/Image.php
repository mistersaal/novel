<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    public function getPathAttribute()
    {
        return '/storage/games/' . $this->novel_id . '/images/' . $this->filename;
    }
}
