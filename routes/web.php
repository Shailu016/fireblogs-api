<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\UserFollowController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CategoryController;


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
Route::group(['middleware' => ['permission:admin', 'auth:sanctum']], function () {
    //
   
    Route::post('post/{post}/unpublish', [PostController::class, 'unpublishPost']);
});
Route::get('post', [PostController::class, 'index']);
Route::post('post/{post}/publish', [PostController::class, 'publishPost']);


Route::get('post/publish', [PostController::class, 'publish']);
Route::post('post/create', [PostController::class, 'store'])->middleware('auth:sanctum');
Route::get('post/{post}', [PostController::class, 'show']);
Route::post('post/{post}/update', [PostController::class, 'update']);
Route::delete('post/{post}/delete', [PostController::class, 'delete']);

Route::post('post/{post}/comments', [CommentsController::class, 'store'])->middleware('auth:sanctum');

Route::post('post/{post}/likes', [LikesController::class, 'store'])->middleware('auth:sanctum');
Route::get('/post/{post}/counts', [LikesController::class, 'count']);
Route::get('/liked/{post}', [LikesController::class, 'userlike'])->middleware('auth:sanctum');

Route::get('/comments', [CommentsController::class, 'index']);
Route::post('/search', [SearchController::class, 'search']);

Route::delete('comments/{comments}/delete', [CommentsController::class, 'delete']);

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
Route::post('reset-password', [AuthController::class, 'reset']);
Route::post('forgot-password', [AuthController::class, 'forgetPassword']);


Route::post("/userProfile", [AuthController::class, "userProfile"])->middleware('auth:sanctum');

Route::get("/profile",[AuthController::class, "profile"])->middleware('auth:sanctum');
Route::post("/upload",[ProfileController::class, "store"])->middleware('auth:sanctum');

Route::get('/user_post',[PostController::class, 'usersPost'])->middleware('auth:sanctum');

Route::post('/reported/{comments}',[ReportController::class, 'store'])->middleware('auth:sanctum');


Route::group(['middleware' => ['permission:admin', 'auth:sanctum']], function () {
    
    Route::get('/reported',[ReportController::class, 'index'])->middleware('auth:sanctum');
    Route::post('/block/{report}',[ReportController::class, 'block'])->middleware('auth:sanctum');
    Route::get('/block_users',[ReportController::class, 'all_block_user'])->middleware('auth:sanctum');
});

Route::post('/follow/{post}',[UserFollowController::class,'index'])->middleware('auth:sanctum');
Route::get('/t',[UserFollowController::class,'userfollower'])->middleware('auth:sanctum');
Route::get('/tt',[UserFollowController::class,'user_follower_post'])->middleware('auth:sanctum');
Route::get('/ttt',[ProfileController::class,'all_users']);
Route::get('/check/{post}',[UserFollowController::class,'check'])->middleware('auth:sanctum');;
Route::get('/all/{user}',[PostController::class,'user_all_post']);



Route::post('/category/create',[CategoryController::class,'store']);
Route::post('/category/{category}/update',[CategoryController::class,'update']);
Route::get('/category',[CategoryController::class,'index']);
Route::get('/category/{category}',[CategoryController::class,'show']);

