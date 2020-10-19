<?php

use App\Http\Controllers\NovelController;
use App\Http\Controllers\UserController;
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

Route::get('/user', UserController::class);

Route::prefix('/novels/{novel}')->group(function () {

    Route::get('/', [NovelController::class, 'index'])->name('novel');
    Route::get('/scene', [NovelController::class, 'currentScene'])
        ->name('novel.scene.current');
    Route::post('/scene/previous', [NovelController::class, 'toPreviousScene'])
        ->name('novel.scene.previous');
    Route::post('/scene/next', [NovelController::class, 'toNextScene'])
        ->name('novel.scene.next');

});
