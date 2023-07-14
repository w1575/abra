<?php

namespace App\Enums\Storages;

use App\Enums\Traits\EnumValuesListTrait;

enum StorageTypeEnum: string
{
    use EnumValuesListTrait;

    case YandexDisk = 'yandexDisk';
}
