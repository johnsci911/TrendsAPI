<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TweetAllController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\UserFollowController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserTweetsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tweets', [TweetController::class, 'index'])->name('tweets.index');
    Route::get('/tweets-all', [TweetAllController::class, 'index'])->name('tweets.all.index');
    Route::get('/tweets/{tweet}', [TweetController::class, 'show'])->name('tweets.show');
    Route::post('/tweets', [TweetController::class, 'store'])->name('tweets.store');
    Route::delete('/tweets/{tweet}', [TweetController::class, 'destroy'])->name('tweets.destroy');
});

Route::get('/users/{user}', [UserProfileController::class, 'show'])->name('user.profile.show');
Route::get('/users/{user}/tweets', [UserTweetsController::class, 'index'])->name('user.tweets.index');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/login', [AuthController::class, 'post'])->name('login');
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
    Route::post('/register', [RegisterController::class, 'store'])->name('register');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/follow/{user}', [UserFollowController::class, 'store'])->name('user.follow.store');
    Route::post('/unfollow/{user}', [UserFollowController::class, 'destroy'])->name('user.follow.destroy');
    Route::get('/is_following/{user}', [UserFollowController::class, 'isFollowing'])->name('user.follow.is_following');
});
