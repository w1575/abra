<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBotTokenRequest;
use App\Http\Requests\UpdateBotTokenRequest;
use App\Models\BotToken;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class BotTokenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('bot-token.index');
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
    public function store(StoreBotTokenRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BotToken $botToken)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BotToken $botToken)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBotTokenRequest $request, BotToken $botToken)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BotToken $botToken)
    {
        //
    }
}
