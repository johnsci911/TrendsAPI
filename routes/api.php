<?php

use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/tweets', function () {
    return Tweet::with('user:id,name,username,avatar')->latest()->get();
});
