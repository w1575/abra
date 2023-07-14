<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTelegramAccountSettingsRequest;
use App\Http\Requests\UpdateTelegramAccountSettingsRequest;
use App\Models\TelegramAccountSettings;

class TelegramAccountSettingsController extends Controller
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
    public function store(StoreTelegramAccountSettingsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TelegramAccountSettings $telegramAccountSettings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TelegramAccountSettings $telegramAccountSettings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTelegramAccountSettingsRequest $request, TelegramAccountSettings $telegramAccountSettings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TelegramAccountSettings $telegramAccountSettings)
    {
        //
    }
}
