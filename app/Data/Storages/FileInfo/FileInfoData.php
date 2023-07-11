<?php

namespace App\Data\Storages\FileInfo;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;

class FileInfoData extends Data
{
    public function __construct(
        public string $name = '',
        public int $size = 0,
        public string $fullPath = '',
        public ?string $mimeType = null,
        public ?string $id = null,
        public ?string $relativePath = null,
        public ?string $publicUrl = null,
    ) {
    }
}
