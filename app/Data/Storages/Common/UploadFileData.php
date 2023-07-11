<?php

namespace App\Data\Storages\Common;

use Spatie\LaravelData\Data;

class UploadFileData extends Data
{
    public function __construct(
        public string $localFilePath,
        public string $remoteFilePath = '/',
        public ?string $remoteFullPath = null,
    ) {
    }
}
