<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTweetsRequest;
use App\Http\Requests\UpdateTweetsRequest;
use App\Models\Tweet;

class TweetsController extends Controller
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
    public function store(StoreTweetsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Tweet $tweets)
    {
        //
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
    public function destroy(Tweet $tweets)
    {
        //
    }
}
