<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\BotToken
 *
 * @property string $token
 * @property int|null $telegram_account_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\BotTokenFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|BotToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BotToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BotToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|BotToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BotToken whereTelegramAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BotToken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BotToken whereUpdatedAt($value)
 * @property-read \App\Models\TelegramAccount|null $telegramAccount
 * @mixin \Eloquent
 */
class BotToken extends Model
{
    use HasFactory;

    protected $guarded = [
        'created_at',
        'updated_at',
        'token',
    ];

    protected $primaryKey = 'token';

    public $incrementing = false;

    public function telegramAccount(): BelongsTo
    {
        return $this->belongsTo(TelegramAccount::class);
    }
}
