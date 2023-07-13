<?php

namespace App\Telegram\Handlers;

use SergiX44\Nutgram\Nutgram;

class OnMessageHandler
{
    public function __invoke(Nutgram $bot): void
    {
        $random = rand(1, 1000);
        $bot->sendMessage($random . '!');
    }
}
