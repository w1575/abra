<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTelegramAccountRequest;
use App\Http\Requests\UpdateTelegramAccountRequest;
use App\Models\TelegramAccount;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class TelegramAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('telegram-account.index');
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
    public function store(StoreTelegramAccountRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TelegramAccount $telegramAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TelegramAccount $telegramAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTelegramAccountRequest $request, TelegramAccount $telegramAccount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TelegramAccount $telegramAccount)
    {
        //
    }
}
