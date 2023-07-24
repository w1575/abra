<?php

namespace App\Models;

use Database\Factories\ConversationStepFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\ConversationStep
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $telegram_account_id
 * @property string $conversation_name Name of the conversation
 * @property mixed $step_data Example: {id: 12, step: edit_name}
 * @property-read TelegramAccount $telegramAccount
 * @method static ConversationStepFactory factory($count = null, $state = [])
 * @method static Builder|ConversationStep newModelQuery()
 * @method static Builder|ConversationStep newQuery()
 * @method static Builder|ConversationStep query()
 * @method static Builder|ConversationStep whereConversationName($value)
 * @method static Builder|ConversationStep whereCreatedAt($value)
 * @method static Builder|ConversationStep whereId($value)
 * @method static Builder|ConversationStep whereStepData($value)
 * @method static Builder|ConversationStep whereTelegramAccountId($value)
 * @method static Builder|ConversationStep whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ConversationStep extends Model
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
