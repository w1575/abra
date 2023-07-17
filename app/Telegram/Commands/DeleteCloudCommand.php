<?php

namespace App\Telegram\Commands;

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Handlers\Type\Command;

class DeleteCloudCommand extends Command
{
    protected string $command = 'delete_storage';

    protected ?string $description = 'Удалите хранилище. Delete cloud storage.';

    public function handle(Nutgram $bot): void
    {
        $storageId = $bot->message()->text;
    }
}
