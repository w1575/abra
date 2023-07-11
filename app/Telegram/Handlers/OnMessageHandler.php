<?php

namespace App\Telegram\Handlers;

use SergiX44\Nutgram\Nutgram;

class OnMessageHandler
{
    public function __invoke(Nutgram $bot): void
    {
        $bot->sendMessage('This is an handler!');
    }
}
