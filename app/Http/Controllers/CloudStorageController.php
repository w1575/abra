<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCloudStorageRequest;
use App\Http\Requests\UpdateCloudStorageRequest;
use App\Models\CloudStorage;

class CloudStorageController extends Controller
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
    public function store(StoreCloudStorageRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CloudStorage $cloudStorage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CloudStorage $cloudStorage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCloudStorageRequest $request, CloudStorage $cloudStorage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CloudStorage $cloudStorage)
    {
        //
    }
}
