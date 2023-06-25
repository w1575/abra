<?php

namespace App\Telegram\Conversations;

use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class StartConversation extends Conversation
{
    /**
     * @throws InvalidArgumentException
     */
    public function start(Nutgram $bot): void
    {
        $bot->sendMessage('This is the first step!');
        $this->next('secondStep');
    }

    /**
     * @throws InvalidArgumentException
     */
    public function secondStep(Nutgram $bot): void
    {
        $bot->sendMessage('Bye!');
        $this->end();
    }
}
