<?php

namespace App\Data\Storages\Settings;

use Spatie\LaravelData\Data;

class StorageSettingsData extends Data
{
    public function __construct(
        public bool $generateFileName = false,
        public bool $overwrite = false,
        public int $lengthOfGeneratedName = 32,
    ) {

    }
}
