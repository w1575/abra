<?php

namespace App\Data\Storages\AccessConfigs;

use Spatie\LaravelData\Data;

class YandexDiskAccessConfigData extends Data
{
    public function __construct(
        public $debugToken,
    ) {
    }
}
