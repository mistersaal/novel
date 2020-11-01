<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateNovelRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:50|unique:novels,name',
            'description' => 'required|string|max:1000',
        ];
    }
}
