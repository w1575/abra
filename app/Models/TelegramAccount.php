<?php

namespace App\Models;

use Database\Factories\TelegramAccountFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\TelegramAccount
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $telegram_id
 * @property string|null $username
 * @property string|null $name
 * @property string|null $avatar
 * @property string|null $token
 * @property int|null $user_id
 * @property string $status
 * @method static TelegramAccountFactory factory($count = null, $state = [])
 * @method static Builder|TelegramAccount newModelQuery()
 * @method static Builder|TelegramAccount newQuery()
 * @method static Builder|TelegramAccount query()
 * @method static Builder|TelegramAccount whereAvatar($value)
 * @method static Builder|TelegramAccount whereCreatedAt($value)
 * @method static Builder|TelegramAccount whereId($value)
 * @method static Builder|TelegramAccount whereName($value)
 * @method static Builder|TelegramAccount whereStatus($value)
 * @method static Builder|TelegramAccount whereTelegramId($value)
 * @method static Builder|TelegramAccount whereToken($value)
 * @method static Builder|TelegramAccount whereUpdatedAt($value)
 * @method static Builder|TelegramAccount whereUserId($value)
 * @method static Builder|TelegramAccount whereUsername($value)
 * @property-read User|null $user
 * @property-read \App\Models\TelegramAccountSettings|null $telegramAccountSettings
 * @property-read \Illuminate\Database\Eloquent\Collection|CloudStorage|null $cloudStorages
 * @property-read int|null $cloud_storages_count
 * @mixin Eloquent
 */
class TelegramAccount extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function telegramAccountSettings(): HasOne
    {
        return $this->hasOne(TelegramAccountSettings::class);
    }

    public function cloudStorages(): HasMany
    {
        return $this->hasMany(CloudStorage::class);
    }
}
