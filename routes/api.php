<?php

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/tweets', function () {
    return Tweet::with('user:id,name,username,avatar')
        ->latest()
        ->paginate(10);
});

Route::get('/tweets/{tweet}', function (Tweet $tweet) {
    return $tweet->load('user:id,name,username,avatar');
});

Route::post('/tweets', function (Request $request) {
    $request->validate([
        'body' => ['required', 'string','max:255'],
    ]);

    return Tweet::create([
        'user_id' => 1,
        'body' => $request->body,
    ]);
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
