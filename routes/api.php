<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TweetAllController;
use App\Http\Controllers\TweetController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::get('/users/{user}', function (User $user) {
    return $user->only(
        'id',
        'name',
        'username',
        'avatar',
        'profile',
        'location',
        'link',
        'link_text',
        'created_at'
    );
});

Route::get('/users/{user}/tweets', function (User $user) {
    return $user->tweets()->with('user:id,name,username,avatar')->latest()->paginate(10);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/login', [AuthController::class, 'post'])->name('login');
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
    Route::post('/register', [RegisterController::class, 'store'])->name('register');
});

Route::middleware('auth:sanctum')->post('/follow/{user}', function (User $user) {
    $authenticatedUser = Auth::user();

    /** @var User $authenticatedUser */
    $authenticatedUser->follow($user);

    return response()->json('followed', 201);
});

Route::middleware('auth:sanctum')->post('/unfollow/{user}', function (User $user) {
    $authenticatedUser = Auth::user();

    /** @var User $authenticatedUser */
    $authenticatedUser->unfollow($user);

    return response()->json('unfollowed', 200);
});

Route::middleware('auth:sanctum')->get('/is_following/{user}', function (User $user) {
    $authenticatedUser = Auth::user();

    /** @var User $authenticatedUser */
    $isFollowing = $authenticatedUser->isFollowing($user);

    return response()->json($isFollowing, 200);
});
