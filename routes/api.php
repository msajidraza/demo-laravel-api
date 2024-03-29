<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPostController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('signup', [UserController::class, 'signUp']);
Route::get('users', [UserController::class, 'getUsers']);
Route::get('user', [UserController::class, 'getUser']);

Route::post('addpost', [UserPostController::class, 'addPost']);
Route::get('posts', [UserPostController::class, 'getPosts']);
Route::get('post/{id}', [UserPostController::class, 'getPostById']);