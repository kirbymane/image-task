<?php

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

Auth::routes();

Route::get('', [App\Http\Controllers\PictureController::class, 'index']);
Route::get('home', [App\Http\Controllers\PictureController::class, 'index'])->name('home');
Route::get('upload/local', [App\Http\Controllers\PictureController::class, 'createFromLocal'])->name('upload.local');
Route::get('upload/remote', [App\Http\Controllers\PictureController::class, 'createFromRemote'])->name('upload.remote');
Route::post('upload/local', [App\Http\Controllers\PictureController::class, 'storeLocal'])->name('store.local');
Route::post('upload/remote', [App\Http\Controllers\PictureController::class, 'storeRemote'])->name('store.remote');
Route::get('edit/{id}', [App\Http\Controllers\PictureController::class, 'update'])->name('update');
Route::post('edit/{id}', [App\Http\Controllers\PictureController::class, 'update']);
Route::get('images/{id}', [App\Http\Controllers\PictureController::class, 'displayImage'])->name('displayImage');
