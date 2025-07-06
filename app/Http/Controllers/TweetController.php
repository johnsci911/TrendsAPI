<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateTweetsRequest;
use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $followers = Auth::user()->follows->pluck('id');

        return Tweet::with('user:id,name,username,avatar')
            ->whereIn('user_id', $followers)
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
            'body' => 'required',
        ]);

        return Tweet::create([
            'user_id' => Auth::user()->id,
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
    public function edit(Tweet $tweets)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTweetsRequest $request, Tweet $tweets)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tweet $tweet)
    {
        abort_if($tweet->user->id !== Auth::user()->id, 403);

        return response()->json($tweet->delete(), 200);
    }
}
