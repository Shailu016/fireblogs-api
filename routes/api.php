<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\LikesController;

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

// post routes
Route::get('post',[PostController::class,'index']);
Route::post('post/create',[PostController::class,'store']);
Route::get('post/{post}',[PostController::class,'show']);
Route::post('post/{post}/update',[PostController::class,'update']);
Route::delete('post/{post}/delete',[PostController::class,'delete']);

Route::get('/comments', [CommentsController::class, 'index']);
Route::post('post/{post}/comments', [CommentsController::class, 'store']);
Route::post('post/{post}/likes', [LikesController::class, 'store']);
Route::get('/search',[SearchController::class,'search']);
