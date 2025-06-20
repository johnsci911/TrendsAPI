<?php

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/tweets-all', function () {
    return Tweet::with('user:id,name,username,avatar')
        ->latest()
        ->paginate(10);
});

Route::middleware('auth:sanctum')->get('/tweets', function () {
    $followers = Auth::user()->follows->pluck('id');

    return Tweet::with('user:id,name,username,avatar')->whereIn('user_id', $followers)
        ->latest()
        ->paginate(10);
});

Route::get('/tweets/{tweet}', function (Tweet $tweet) {
    return $tweet->load('user:id,name,username,avatar');
});

Route::middleware('auth:sanctum')->post('/tweets', function (Request $request) {
    $request->validate([
        'body' => ['required', 'string','max:255'],
    ]);

    $userId = Auth::id();

    return Tweet::create([
        'user_id' => $userId,
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

Route::get('/users/{user}/tweets', function (User $user) {
    return $user->tweets()->with('user:id,name,username,avatar')->latest()->paginate(10);
});

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
        'device_name' => ['required','string'],
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['Invalid credentials'],
        ]);
    }

    $token = $user->createToken($request->device_name)->plainTextToken;

    return response()->json([
        'token' => $token,
        'user' => $user->only('id', 'name', 'email', 'username', 'avatar'),
    ], 201);
});

Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'username' => 'required|min:4|unique:users',
        'password' => 'required|confirmed|min:6',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'username' => $request->username,
        'password' => Hash::make($request->password),
    ]);

    $user->follows()->attach($user);

    return response()->json($user, 201);
});

Route::middleware('auth:sanctum')->delete('/tweets/{tweet}', function (Tweet $tweet) {
    abort_if($tweet->user->id !== Auth::id(), 403);

    return response()->json($tweet->delete(), 200);
});

Route::post('/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();

    return response()->json('Logged out successfully.', 200);
})->middleware('auth:sanctum');

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
