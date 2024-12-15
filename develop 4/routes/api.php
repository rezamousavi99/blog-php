<?php

use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ExternalApiController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureTokenIsNotExpired;

// User Routes
Route::group([], function () {
    Route::post('/register', [UserController::class, 'registerUser']);
    Route::post('/login', [UserController::class, 'loginUser']);
    Route::get('/logout', [UserController::class, 'logoutUser'])->middleware('auth:sanctum');
});

// Post Routes
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/create-post', [PostController::class, 'storeNewPost'])->middleware(EnsureTokenIsNotExpired::class);
    Route::get('/posts', [PostController::class, 'showAllPost'])->name('posts.index');
    Route::get('/post/{post}', [PostController::class, 'showSinglePost'])->name('show-single-post')->name('posts.show');
    Route::delete('/delete-post/{post}', [PostController::class, 'deletePost'])->middleware('can:delete,post');
    Route::put('/update-post/{post}', [PostController::class, 'updatePost'])->middleware('can:update,post');
});

Route::get('/search-posts/{term}', [PostController::class, 'searchPost']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/post/{post}/comment', [CommentController::class, 'commentPost']);

    // Like and Unlike Posts
    Route::post('/post/{post}/like', [LikeController::class, 'likePost']);
    Route::delete('/post/{post}/unlike', [LikeController::class, 'unlikePost']);

    // Like and Unlike Comments
    Route::post('/comment/{comment}/like', [LikeController::class, 'likeComment']);
    Route::delete('/comment/{comment}/unlike', [LikeController::class, 'unlikeComment']);

    Route::post('/post/{post}/schedule', [PostController::class, 'schedulePost'])->middleware('can:schedule,post');;
});

// Routes for the admin to access the exports
Route::middleware(['auth:sanctum', 'is_admin'])->group(function () {
    Route::get('/admin/exports', [ExportController::class, 'index']);
    Route::get('/admin/exports/download/{filename}', [ExportController::class, 'download']);
});

Route::get('/fetch-data-api-endpoint', [ExternalApiController::class, 'getFormattedData']);

Route::get('/notifications', [NotificationController::class, 'index'])->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
