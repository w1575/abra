<?php

namespace App\Data\Storages\YandexDisk;

use App\Data\Storages\FileInfo\FileInfoData;
use App\Data\Storages\YandexDisk\FileListResponse\EmbeddedData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class FilesListResponseData extends Data
{
    public function __construct(
        #[MapName('_embedded')]
        public EmbeddedData $embedded,
    ) {}
}
