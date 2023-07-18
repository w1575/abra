<?php

namespace App\Telegram\Conversations;

use App\Models\TelegramAccountSettings;
use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class SetLanguageConversation extends Conversation
{
    /**
     * @throws InvalidArgumentException
     */
    public function start(Nutgram $bot): void
    {
        $message =  $this->getLocales();
        $message .=  PHP_EOL . 'Например, если отправишь "en", в качестве языка будет установлен Английский.';
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
            return;
        }

        $this->setLocale($bot->user()?->id, $locale);
        app()->setLocale($locale);

        $bot->sendMessage(__('telegram.language_been_set'));
        $this->end();
    }


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

    protected function setLocale(?int $id, array|bool|string|null $locale): void
    {
        $settings = TelegramAccountSettings::query()
            ->whereRelation('telegramAccount', 'telegram_id', $id)
            ->first()
        ;

        $settings->update([
            'locale' => $locale
        ]);
    }
}
