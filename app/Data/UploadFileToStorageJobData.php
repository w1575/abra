<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class UploadFileToStorageJobData extends Data
{
    public function __construct(
        public int $userId,
    ) {}
}
