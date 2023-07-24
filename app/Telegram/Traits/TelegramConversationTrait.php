<?php

namespace App\Telegram\Traits;

use App\Models\ConversationStep;
use App\Models\TelegramAccount;
use SergiX44\Nutgram\Nutgram;

trait TelegramConversationTrait
{
    public function getTelegramAccount(Nutgram $bot): ?TelegramAccount
    {
        return $bot->get('telegramAccount') ?? TelegramAccount::whereTelegramId($bot->userId())->first();
    }

    protected function getConversationStep(Nutgram $bot): ?ConversationStep
    {
        $account = $this->getTelegramAccount($bot);
        return ConversationStep::query()
            ->firstOrCreate([
                'conversation_name' => static::CONVERSATION_STEP_NAME,
                'telegram_account_id' => $account->id,
            ])
        ;
    }
}