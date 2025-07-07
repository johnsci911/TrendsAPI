<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserFollowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(User $user)
    {
        $authenticatedUser = Auth::user();

        /** @var User $authenticatedUser */
        $authenticatedUser->follow($user);

        return response()->json('followed', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $authenticatedUser = Auth::user();

        /** @var User $authenticatedUser */
        $authenticatedUser->unfollow($user);

        return response()->json('unfollowed', 200);
    }

    /**
     * Check if user is following another user
     *
     * @param User $user
     * @return bool
     */
    public function isFollowing(User $user)
    {
        $authenticatedUser = Auth::user();

        /** @var User $authenticatedUser */
        $isFollowing = $authenticatedUser->isFollowing($user);

        return response()->json($isFollowing, 200);
    }
}
