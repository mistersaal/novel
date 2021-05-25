<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NovelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'author' => new AuthorResource($this->whenLoaded('author')),
            'name' => $this->name,
            'description' => $this->description,
            'first_scene_id' => $this->first_scene_id,
            'cover' => new ImageResource($this->cover),
            'is_banned' => $this->is_banned,
        ];
    }

    public static $wrap = 'novel';
}
