<?php

namespace App\Telegram\Conversations;

use App\Enums\TelegramAccount\StatusEnum;
use App\Models\BotToken;
use App\Models\TelegramAccount;
use App\Models\TelegramAccountSettings;
use Exception;
use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\User\User;

class SetTokenConversation extends Conversation
{
    /**
     * @throws InvalidArgumentException
     */
    public function start(Nutgram $bot): void
    {
        $bot->sendMessage(__('telegram.start_command.need_set_the_token'));
        $this->next('setToken');
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setToken(Nutgram $bot): void
    {
        $token = $bot->message()->text;
        try {
            $this->validateToken($token);
        } catch (Exception $e) {
            $bot->sendMessage($e->getMessage() . PHP_EOL . __('telegram.start_command.try_again'));
            return;
        }
        $this->createTelegramUser($bot->user(), $token);
        $bot->sendMessage(__('telegram.start_command.token_set'));
        $this->end();
    }

    /**
     * @throws Exception
     */
    private function validateToken(?string $token): void
    {
        $token = ltrim($token);
        if (mb_strlen($token) < 32) {
            throw new \Exception(__('bot_tokens.short_token'));
        }
        BotToken::whereToken($token)->firstOr(callback: fn () => throw new Exception(__('bot_tokens.not_found')));
    }

    protected function createTelegramUser(?User $user, ?string $token): void
    {
        $telegramAccount = TelegramAccount::whereTelegramId($user->id)->first();
        $telegramAccount->update(['token' => $token]);

        BotToken::whereToken($token)->delete();
    }
}
