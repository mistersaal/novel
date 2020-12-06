<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditImageRequest;
use App\Http\Requests\LoadImageRequest;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use App\Models\Novel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('verified');
    }

    public function index(Novel $novel)
    {
        return ImageResource::collection($novel->images);
    }

    public function create(Novel $novel, LoadImageRequest $request)
    {
        $path = $request->file('file')->store('/public/games/' . $novel->id . '/images');
        $image = new Image();
        $image->name = $request->name;
        $image->filename = basename($path);
        $novel->images()->save($image);

        return new ImageResource($image);
    }

    public function get(Novel $novel, Image $image)
    {
        return new ImageResource($image);
    }

    public function edit(Novel $novel, Image $image, EditImageRequest $request)
    {
        $image->name = $request->name;
        $image->save();

        return new ImageResource($image);
    }

    public function delete(Novel $novel, Image $image)
    {
        $path = $image->path;
        $result = Storage::delete($image->systemPath);
        $image->delete();
    }
}
