<?php

namespace App\Telegram\Handlers;

use SergiX44\Nutgram\Nutgram;

class OnMessageHandler
{
    public function __invoke(Nutgram $bot): void
    {
        $random = rand(1, 1000);
        file_put_contents(
            storage_path('app/public/messages/message' . $random . '.json'),
            json_encode($bot->message())
        );
        $bot->sendMessage($random . '!');
    }
}
