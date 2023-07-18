<?php

namespace App\Telegram\Middleware;

use App\Models\TelegramAccount;
use App\Telegram\Conversations\StartConversation;
use SergiX44\Nutgram\Telegram\Types\User\User;
use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Nutgram\Nutgram;

class CheckUserStatusMiddleware
{
    /**
     * @throws InvalidArgumentException
     */
    public function __invoke(Nutgram $bot, $next): void
    {
        $telegramAccount = $this->getTelegramAccount($bot->user());
        if ($telegramAccount === null) {
            $bot->sendMessage(__('bot-response.access.user_not_found'));
            return;
        }

        $bot->set('telegramAccount', $telegramAccount);

        $next($bot);
    }


    protected function getTelegramAccount(?User $user): ?TelegramAccount
    {
        return TelegramAccount::whereTelegramId($user->id)->whereNotNull('token')->first();
    }
}
