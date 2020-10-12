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

Route::get('/novels/{novel}', [NovelController::class, 'index'])->name('game');
Route::get('/novels/{novel}/scene', [NovelController::class, 'currentScene'])
    ->name('currentScene');
