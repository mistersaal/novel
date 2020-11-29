<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatchNovelRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'string|max:50|unique:novels,name',
            'description' => 'string|max:1000',
            'image_id' => 'exists:images,id'
        ];
    }
}
