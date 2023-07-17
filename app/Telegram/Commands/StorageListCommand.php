<?php

namespace App\Telegram\Commands;

use App\Models\CloudStorage;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Handlers\Type\Command;

class StorageListCommand extends Command
{
    protected string $command = 'storage_list';

    protected ?string $description = 'Получить список хранилищ. (Get list of available storages)';

    public function handle(Nutgram $bot): void
    {
        $storages = CloudStorage::query()
            ->whereRelation(
                'telegramAccount',
                'telegram_id',
                $bot->user()->id
            )
            ->get()
        ;

        $list = "";

        $storages->each(function (CloudStorage $item, $key) use (&$list) {
            $list .= PHP_EOL . "{$item->id} : {$item->name}";
        });

        $bot->sendMessage($list);
    }
}
