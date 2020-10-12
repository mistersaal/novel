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
            'text' => $this->text,
            'image' => new ImageResource($this->image),
            'music' => new MusicResource($this->music),
            'choices' => ChoiceResource::collection($this->choices),
        ];
    }

    public static $wrap = 'scene';
}
