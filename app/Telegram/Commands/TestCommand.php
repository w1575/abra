<?php

namespace App\Telegram\Commands;

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Handlers\Type\Command;

class TestCommand extends Command
{
    protected string $command = 'test';

    protected ?string $description = 'Test command dat send chat id.';

    public function handle(Nutgram $bot): void
    {
        $bot->sendMessage("Your chat_id => {$bot->chatId()}");
    }
}
