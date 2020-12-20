<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SceneResource extends JsonResource
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
            'name' => $this->name,
            'text' => $this->text,
            'image' => new ImageResource($this->image),
            'music' => new MusicResource($this->music),
            'choices' => ChoiceResource::collection($this->choicesWithNextScene),
            'last_scene' => $this->isLastScene(),
        ];
    }

    public static $wrap = 'scene';
}
