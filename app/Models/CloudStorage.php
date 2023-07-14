<?php

namespace App\Models;

use Database\Factories\CloudStorageFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\CloudStorage
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $name
 * @property int $telegram_account_id
 * @property string $storage_type
 * @property mixed|null $storage_settings
 * @property mixed|null $storage_config
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
 * @mixin Eloquent
 * @property-read TelegramAccount $telegramAccount
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


}
