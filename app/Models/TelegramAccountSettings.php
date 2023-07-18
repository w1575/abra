<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use PhpParser\Builder;

/**
 * App\Models\TelegramAccountSettings
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $locale
 * @property int|null $cloud_storage_id
 * @method static \Database\Factories\TelegramAccountSettingsFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramAccountSettings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramAccountSettings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramAccountSettings query()
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramAccountSettings whereCloudStorageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramAccountSettings whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramAccountSettings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramAccountSettings whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramAccountSettings whereUpdatedAt($value)
 * @property int|null $telegram_account_id
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramAccountSettings whereTelegramAccountId($value)
 * @property-read \App\Models\CloudStorage|null $cloudStorage
 * @property-read \App\Models\TelegramAccount|null $telegramAccount
 * @mixin \Eloquent
 */
class TelegramAccountSettings extends Model
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

    public function cloudStorage(): BelongsTo
    {
        return  $this->belongsTo(CloudStorage::class);
    }
}
