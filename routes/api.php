<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookmarkController;

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


// post routes

Route::get('post', [PostController::class,'index']);
Route::post('post/create', [PostController::class,'store'])->middleware('auth:sanctum');
Route::get('post/{post}', [PostController::class,'show']);
Route::post('post/{post}/update', [PostController::class,'update']);
Route::delete('post/{post}/delete', [PostController::class,'delete']);
    
Route::post('post/{post}/comments', [CommentsController::class, 'store'])->middleware('auth:sanctum');
Route::post('post/{post}/likes', [LikesController::class, 'store'])->middleware('auth:sanctum');
Route::get('/post/{post}/counts', [LikesController::class, 'count']);
Route::get('/liked/{post}', [LikesController::class, 'userlike'])->middleware('auth:sanctum');

Route::get('/comments', [CommentsController::class, 'index']);
Route::post('/search', [SearchController::class,'search']);

// Route::post('login', [PassportController::class,'login']);
// Route::post('register', [PassportController::class,'register']);
  
// Route::middleware('auth:api')->group(function () {
//     Route::get('user', [PassportController::class,'details']);
//  });

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('profile', [AuthController::class, 'profile']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('post/{post}/bookmark', [BookmarkController::class, 'add']);
    Route::delete('post/{post}/bookmark', [BookmarkController::class, 'remove']);
    Route::get('bookmark', [BookmarkController::class, 'get']);
    Route::get('check/bookmark', [BookmarkController::class, 'check']);
});
