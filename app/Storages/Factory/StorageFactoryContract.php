<?php

namespace App\Storages\Factory;

use App\Models\CloudStorage;
use App\Storages\StorageContract;

interface StorageFactoryContract
{
    public function make(CloudStorage $cloudStorage): StorageContract;
}