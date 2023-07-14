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
        $userExist = $this->validateUser($bot->user());
        if (!$userExist) {
            $bot->sendMessage(__('bot-response.access.user_not_found'));
            return;
        }
        $next($bot);
    }


    protected function validateUser(?User $user): bool
    {
        return TelegramAccount::whereTelegramId($user->id)->exists();
    }
}
