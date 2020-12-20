<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditSceneRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'image_id' => 'nullable|exists:images,id',
            'text' => 'required|string',
            'music_id' => 'nullable|exists:music,id',
            'question' => 'nullable|string',
            'choice_value' => 'nullable|string|max:255',
        ];
    }
}
