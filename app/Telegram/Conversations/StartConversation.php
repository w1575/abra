<?php

namespace App\Telegram\Conversations;

use Exception;
use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class StartConversation extends Conversation
{

    protected function getLocaleKeys(): array
    {
        return array_keys(config('app.locales'));
    }
    protected function getLocales(): array|string
    {
//        return str_replace(
//            '=',
//            '=>',
//            http_build_query(config('app.locales'), null, ',')
//        );
        return implode(PHP_EOL, array_map(
            fn(string $v, string $k) => sprintf("%s => '%s'", $k, $v),
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
        $bot->sendMessage(__('telegram.start_command.token_set'));
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
        if (mb_strlen($token) < 5) {
            throw new Exception(__('telegram.start_command.token_in_use'));
            // TODO: make validation
        }
    }
}
