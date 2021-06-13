<?php

use App\Http\Controllers\EditScenesController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\NovelSceneController;
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

Route::get('/user', [UserController::class, 'get'])->name('user');
Route::patch('/user', [UserController::class, 'patch'])->name('user.edit');

Route::get('/novels', [NovelController::class, 'all'])->name('novel.all');
Route::post('/novels', [NovelController::class, 'create'])->name('novel.create');

Route::prefix('/novels/{novel}')->group(function () {

    Route::get('/', [NovelController::class, 'index'])->name('novel');
    Route::patch('/', [NovelController::class, 'patch'])->name('novel.patch');

    Route::get('/scene', [NovelSceneController::class, 'currentScene'])
        ->name('novel.scene.current');
    Route::post('/scene/previous', [NovelSceneController::class, 'toPreviousScene'])
        ->name('novel.scene.previous');
    Route::post('/scene/next', [NovelSceneController::class, 'toNextScene'])
        ->name('novel.scene.next');

    Route::get('/images', [ImageController::class, 'index'])->name('novel.images');
    Route::post('/images', [ImageController::class, 'create'])->name('novel.image.create');
    Route::get('/images/{image}', [ImageController::class, 'get'])->name('novel.image');
    Route::patch('/images/{image}', [ImageController::class, 'edit'])->name('novel.image.edit');
    Route::delete('/images/{image}', [ImageController::class, 'delete'])->name('novel.image.delete');

    Route::get('/edit/scenes', [EditScenesController::class, 'index'])->name('novel.edit.scenes');
    Route::post('/edit/scenes', [EditScenesController::class, 'create'])->name('novel.edit.scenes.create');
    Route::patch('/edit/scenes/{scene}', [EditScenesController::class, 'edit'])->name('novel.edit.scenes.edit');
    Route::delete('/edit/scenes/{scene}', [EditScenesController::class, 'delete'])->name('novel.edit.scenes.delete');
});

Route::prefix('/admin')->group(function () {

    Route::post('/block/user/{user}', [\App\Http\Controllers\AdminController::class, 'blockUser']);
    Route::post('/unblock/user/{user}', [\App\Http\Controllers\AdminController::class, 'unblockUser']);
    Route::post('/block/novel/{novel}', [\App\Http\Controllers\AdminController::class, 'blockNovel']);
    Route::post('/unblock/novel/{novel}', [\App\Http\Controllers\AdminController::class, 'unblockNovel']);
});
