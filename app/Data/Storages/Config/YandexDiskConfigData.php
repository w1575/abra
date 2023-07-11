<?php

namespace App\Data\Storages\Config;

use Spatie\LaravelData\Data;

class YandexDiskConfigData extends Data
{
    public function __construct(
        public $debugToken,
    ) {
    }
}
