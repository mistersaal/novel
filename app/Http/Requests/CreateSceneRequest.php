<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSceneRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'image_id' => 'nullable|exists:images,id',
            'text' => 'required|string',
            'music_id' => 'nullable|exists:music,id',
            'question' => 'nullable|string',
            'parent_scene_id' => 'nullable|exists:scenes,id',
            'choice_value' => 'nullable|string|max:255',
        ];
    }
}
