<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoadImageRequest extends FormRequest
{
    public function rules()
    {
        return [
            'file' => 'required|image',
            'name' => 'required|string|max:255',
        ];
    }
}
