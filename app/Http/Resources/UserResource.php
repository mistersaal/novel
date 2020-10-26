<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'novels' => NovelResource::collection($this->novels),
            'saves' => SaveResource::collection($this->saves),
            'hasVerifiedEmail' => $this->hasVerifiedEmail(),
        ];
    }

    public static $wrap = 'user';
}
