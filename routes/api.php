<?php

use App\Http\Controllers\NovelController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/novels/{novel}')->middleware('auth:sanctum')->group(function () {

    Route::get('/', [NovelController::class, 'index'])->name('novel');
    Route::get('/scene', [NovelController::class, 'currentScene'])
        ->name('novel.scene.current');
    Route::post('/scene/previous', [NovelController::class, 'toPreviousScene'])
        ->name('novel.scene.previous');
    Route::post('/scene/next', [NovelController::class, 'toNextScene'])
        ->name('novel.scene.next');

});
