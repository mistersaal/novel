<?php

use App\Http\Controllers\NovelController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'welcome');

Auth::routes();

Route::prefix('/novels/{novel}')->group(function () {

    Route::get('/', [NovelController::class, 'index'])->name('game');
    Route::get('/scene', [NovelController::class, 'currentScene'])
        ->name('currentScene');
    Route::post('/scene/previous', [NovelController::class, 'toPreviousScene'])
        ->name('toPreviousScene');

});
