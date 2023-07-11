<?php

namespace App\Data\Storages\YandexDisk\FileListResponse;

use App\Data\Storages\FileInfo\FileInfoData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class EmbeddedData extends Data
{
    public function __construct(
        public string $sort,
        #[DataCollectionOf(FileInfoData::class)]
        public DataCollection $items,
    ) {
    }
}
