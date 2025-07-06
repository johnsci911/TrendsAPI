<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TweetAllController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Tweet::with('user:id,name,username,avatar')
            ->latest()
            ->paginate(10);
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
    public function store(Request $request)
    {
        $request->validate([
            'body' => ['required', 'string','max:255'],
        ]);

        $userId = Auth::id();

        return Tweet::create([
            'user_id' => $userId,
            'body' => $request->body,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tweet $tweet)
    {
        return $tweet->load('user:id,name,username,avatar');
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
    public function destroy(Tweet $tweet)
    {
        abort_if($tweet->user->id !== Auth::id(), 403);

        return response()->json($tweet->delete(), 200);
    }
}
