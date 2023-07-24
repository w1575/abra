<?php

namespace App\Models;

use App\Data\Storages\Settings\StorageSettingsData;
use Database\Factories\CloudStorageFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

use Illuminate\Database\Eloquent\Casts\Json;

/**
 * App\Models\CloudStorage
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $name
 * @property int $telegram_account_id
 * @property string $storage_type
 * @property mixed|StorageSettingsData|null $storage_settings
 * @property string|null $access_config
 * @method static CloudStorageFactory factory($count = null, $state = [])
 * @method static Builder|CloudStorage newModelQuery()
 * @method static Builder|CloudStorage newQuery()
 * @method static Builder|CloudStorage query()
 * @method static Builder|CloudStorage whereCreatedAt($value)
 * @method static Builder|CloudStorage whereId($value)
 * @method static Builder|CloudStorage whereName($value)
 * @method static Builder|CloudStorage whereStorageAccess($value)
 * @method static Builder|CloudStorage whereStorageSettings($value)
 * @method static Builder|CloudStorage whereStorageType($value)
 * @method static Builder|CloudStorage whereUpdatedAt($value)
 * @method static Builder|CloudStorage whereUserId($value)
 * @property-read TelegramAccount $telegramAccount
 * @method static Builder|CloudStorage whereAccessConfig($value)
 * @method static Builder|CloudStorage whereTelegramAccountId($value)
 * @method static Builder|CloudStorage whereTelegramId(int $id)
 * @mixin Eloquent
 */
class CloudStorage extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function telegramAccount(): BelongsTo
    {
        return $this->belongsTo(TelegramAccount::class);
    }

    protected function storageSettings(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value !== null ? StorageSettingsData::from($value) : null,
            set: fn (?StorageSettingsData $value) => $value?->toJson(),
        );
    }

    public function scopeWhereTelegramId(Builder $builder, int $id): void
    {
//        $builder->leftJoin(
//            'telegram_accounts',
//            'cloud_storages.telegram_account_id',
//            '=',
//            'telegram_accounts.id'
//        );

//        $builder->where('telegram_accounts.telegram_id', $id);

        $builder->whereRelation(
            'telegramAccount',
            'telegram_accounts.telegram_id',
            '=',
            $id
        );
    }

    public function getIsDefault(): bool
    {
        return TelegramAccountSettings::whereTelegramAccountId($this->telegram_account_id)
                ->first()?->cloud_storage_id == $this->id
        ;
    }
}
