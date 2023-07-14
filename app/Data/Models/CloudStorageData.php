<?php

namespace App\Data\Models;

use App\Enums\Storages\StorageTypeEnum;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Data;

class CloudStorageData extends Data
{
    public function __construct(
        public int $id,
        #[WithCast(DateTimeInterfaceCast::class)]
        public ?Carbon $created_at,
        #[WithCast(DateTimeInterfaceCast::class)]
        public ?Carbon $updated_at,
        public string $name,
        public ?int $telegram_account_id,
        #[WithCast(EnumCast::class)]
        public StorageTypeEnum $storage_type,
        public $storage_access,
        public $storage_settings,
    ) {}
}
