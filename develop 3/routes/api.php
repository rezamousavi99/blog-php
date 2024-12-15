<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// User Routes #todo.ma: use route groups
Route::post('/register', [UserController::class, 'registerUserApi']);
Route::post('/login', [UserController::class, 'loginUserApi']);
Route::get('/logout', [UserController::class, 'logoutUserApi'])->middleware('auth:sanctum');

// Post Routes
Route::post('/create-post', [PostController::class, 'storeNewPostApi'])->middleware('auth:sanctum');
Route::get('/posts', [PostController::class, 'showAllPostApi']);
Route::get('/post/{post}', [PostController::class, 'showSinglePostApi']);
Route::delete('/delete-post/{post}', [PostController::class, 'deletePostApi'])->middleware('auth:sanctum', 'can:delete,post');
Route::put('/update-post/{post}', [PostController::class, 'updatePostApi'])->middleware('auth:sanctum', 'can:update,post');

// Like Posts
Route::post('/post/{post}/like', [PostController::class, 'likePostApi'])->middleware('auth:sanctum');

Route::post('/post/{post}/like', [PostController::class, 'likePostApi'])->middleware('auth:sanctum');

Route::get('/search-posts/{term}', [PostController::class, 'searchPostApi']);


// Fetch users that have liked specific post
Route::get('/users/{postId}/likes', [ReportController::class, 'usersLikedPostApi']);

// Fetch all tags with count of their associated post
Route::get('/tags', [ReportController::class, 'tagsPostCountApi']);

// Only Admins can export posts as excel
Route::get('/posts-report-excel', [ReportController::class, 'downloadPostsAsExcel'])->middleware('auth:sanctum');

//Route::post('/test', [PostController::class, 'test'])->middleware('auth:sanctum');


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
