<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoadImageRequest;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use App\Models\Novel;
use Illuminate\Http\Request;

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

    // TODO
    public function edit(Novel $novel, Image $image)
    {
        //
    }

    // TODO
    public function destroy(Novel $novel, Image $image)
    {
        //
    }
}
