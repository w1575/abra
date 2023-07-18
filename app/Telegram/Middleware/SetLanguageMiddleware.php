<?php

namespace App\Telegram\Middleware;

use App\Models\TelegramAccountSettings;
use SergiX44\Nutgram\Nutgram;

class SetLanguageMiddleware
{
    public function __invoke(Nutgram $bot, $next): void
    {
        $settings = TelegramAccountSettings::whereRelation(
            'telegramAccount',
            'telegram_id', '=', $bot->user()->id
        )->first();

        if ($settings === null) {
            app()->setLocale('ru');
        } else {
            app()->setLocale($settings->locale);
        }

        $next($bot);
    }
}
