<?php

namespace App\Telegram\Conversations;

use App\Enums\TelegramAccount\StatusEnum;
use App\Models\BotToken;
use App\Models\TelegramAccount;
use Exception;
use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\User\User;

class StartConversation extends Conversation
{
    protected function getLocaleKeys(): array
    {
        return array_keys(config('app.locales'));
    }
    protected function getLocales(): array|string
    {
        return implode(PHP_EOL, array_map(
            fn (string $v, string $k) => sprintf("%s => '%s'", $k, $v),
            config('app.locales'),
            $this->getLocaleKeys(),
        ));

    }

    /**
     * @throws InvalidArgumentException
     */
    public function start(Nutgram $bot): void
    {
        $message = 'Привет! Сначала нужно настроить язык.' .  PHP_EOL;
        $message .= '(Hello! First you need to set the language)' . PHP_EOL;
        $message .=  $this->getLocales();
        $message .= 'Например, если отправишь "en", в качестве языка будет установлен Английский.';
        $message .= '(For example, if you send "en", the language will be set to English)';
        $bot->sendMessage($message);
        $this->next('setLanguage');
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setLanguage(Nutgram $bot): void
    {
        $locale = mb_convert_case($bot->message()->text, MB_CASE_LOWER, 'UTF-8');
        if (!in_array($locale, $this->getLocaleKeys())) {
            $bot->sendMessage('Выбран неверный язык (Invalid language selected).');
            $this->next('setLanguage');
            return;
        }

        $this->setLocale();
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
            $this->next('setToken');
            return;
        }
        $this->createTelegramUser($bot->user(), $token);
        $bot->sendMessage(__('telegram.start_command.token_set'));
        $this->end();
    }

    private function setLocale(): void
    {
        // TODO: set locale in db
    }

    /**
     * @throws Exception
     */
    private function validateToken(?string $token): void
    {
        BotToken::whereToken($token)->firstOr(callback: fn() => new Exception(__('bot_tokens.not_found')));
    }

    protected function createTelegramUser(?User $user, ?string $token): void
    {
        $name = $user->first_name . $user->last_name;
        TelegramAccount::make([
            'telegram_id' => $user->id,
            'username' => $user->username ?? 'UserId' . $user->id,
            'name' => empty($name) ? 'UserId' . $user->id : $name,
            'avatar' => '',
            'token' => $token,
            'user_id' => null,
            'status' => StatusEnum::Active->value,
        ])->save();
        BotToken::whereToken($token)->delete();
    }
}
