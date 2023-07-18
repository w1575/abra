<?php

namespace App\Data\Telegram;

use App\Enums\Bot\FileTypeEnum;
use App\Storages\StorageContract;
use Spatie\LaravelData\Data;

class FileHandlerDispatchData extends Data
{
    public function __construct(
        public int $fileId,
        public FileTypeEnum $fileType,
        public StorageContract $storage,
    ) {

    }
}
