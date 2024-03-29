<?php

namespace App\Telegram\Handlers;

use App\Data\Telegram\FileHandlerDispatchData;
use App\Data\Telegram\Response\PhotoData;
use App\Enums\Storages\StorageTypeEnum;
use App\Models\CloudStorage;
use App\Models\TelegramAccountSettings;
use App\Storages\StorageContract;
use App\Storages\YandexDisk\YandexDiskStorageContract;
use App\Telegram\Handlers\traits\FileHandlerTrait;
use SergiX44\Nutgram\Nutgram;

class PhotoHandler
{
    use FileHandlerTrait;

    public function __invoke(Nutgram $bot): void
    {
        $photoSize = array_pop($bot->message()->photo);
        dump($photoSize->file_id);
        $this->dispatchJob($bot, $photoSize->file_id);
    }
}
