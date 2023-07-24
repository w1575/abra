<?php

namespace App\Telegram\Conversations;

use App\Models\TelegramAccountSettings;
use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Nutgram\Conversations\InlineMenu;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;

class SetLanguageConversation extends InlineMenu
{
    /**
     * @throws InvalidArgumentException
     */
    public function start(Nutgram $bot): void
    {
        $message =  'Выберите язык. ';
        $message .= PHP_EOL . 'Choice language.';

        $this->setSkipMiddlewares(true)
            ->next('ru@setLanguage');

        $this->menuText($message)
            ->addButtonRow(InlineKeyboardButton::make('Русский', callback_data: 'ru@setLanguage'))
            ->addButtonRow(InlineKeyboardButton::make('English', callback_data: 'en@setLanguage'))
            ->orNext('none')
            ->showMenu(noMiddlewares: true)
        ;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setLanguage(Nutgram $bot): void
    {
        $locale = $bot->callbackQuery()->data;
        if (!in_array($locale, $this->getLocaleKeys())) {
            $bot->sendMessage('Выбран неверный язык (Invalid language selected).');
            return;
        }

        TelegramAccountSettings::whereRelation(
            'telegramAccount',
            'telegram_id',
            '=',
            $bot->userId(),
        )->update([
            'locale' => $locale,
        ]);

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

    /**
     * @throws InvalidArgumentException
     */
    public function none(Nutgram $bot): void
    {
        $bot->sendMessage('ok');
        $this->end();
    }
}
