<?php

namespace App\Data\Storages\YandexDisk\UploadFile;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;

class UploadUrlResponseData extends Data
{
    public function __construct(
        #[MapName('operation_id')]
        public string $operationId,
        public string $href,
        public string $method,
        public ?bool $templated,
    ) {}
}
