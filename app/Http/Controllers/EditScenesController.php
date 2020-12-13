<?php

namespace App\Http\Controllers;


use App\Models\Novel;
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
}
