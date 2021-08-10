<?php

use Illuminate\Http\Request;
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


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/blog/create', [\App\Http\Controllers\BlogController::class, 'create']);
    Route::post('/post/create', [\App\Http\Controllers\PostController::class, 'create']);
    Route::post('/image/create', [\App\Http\Controllers\ImageController::class, 'create']);
});


Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('add-blog-comment', [\App\Http\Controllers\BlogController::class, 'addBlogComment']);
Route::post('add-post-comment', [\App\Http\Controllers\PostController::class, 'addComment']);
Route::post('add-image-comment', [\App\Http\Controllers\ImageController::class, 'addComment']);
Route::post('blogs', [\App\Http\Controllers\BlogController::class, 'index']);
Route::post('posts', [\App\Http\Controllers\PostController::class, 'index']);
Route::post('images', [\App\Http\Controllers\ImageController::class, 'index']);

