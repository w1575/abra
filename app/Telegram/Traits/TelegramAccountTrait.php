<?php

namespace App\Telegram\Traits;

use App\Models\TelegramAccount;
use SergiX44\Nutgram\Nutgram;

trait TelegramAccountTrait
{
    public function getTelegramAccount(Nutgram $bot): ?TelegramAccount
    {
        return $bot->get('telegramAccount') ?? TelegramAccount::whereTelegramId($bot->userId())->first();
    }
}