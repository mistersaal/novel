<?php

namespace App\Http\Controllers;


use App\Http\Requests\CreateSceneRequest;
use App\Http\Requests\EditSceneRequest;
use App\Http\Resources\SceneResource;
use App\Models\Novel;
use App\Models\Scene;
use App\Services\EditScenesService;

class EditScenesController extends Controller
{
    private $service;

    public function __construct(EditScenesService $service)
    {
        $this->service = $service;
    }

    public function index(Novel $novel)
    {
        return $this->service->getScenesTree($novel);
    }

    public function create(Novel $novel, CreateSceneRequest $request)
    {
        $scene = $this->service->createScene($novel, $request->validated());

        return new SceneResource($scene);
    }

    public function edit(Novel $novel, Scene $scene, EditSceneRequest $request)
    {
        $scene = $this->service->editScene($scene, $request->validated());

        return new SceneResource($scene);
    }

    public function delete(Novel $novel, Scene $scene)
    {
        $this->service->deleteScene($novel, $scene);
    }
}
