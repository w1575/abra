<?php

namespace App\Telegram\Handlers\traits;

use App\Data\Telegram\FileHandlerDispatchData;
use App\Enums\Storages\StorageTypeEnum;
use App\Jobs\Bot\UploadFileToStorageJob;
use App\Models\CloudStorage;
use App\Models\TelegramAccount;
use App\Models\TelegramAccountSettings;
use App\Storages\StorageContract;
use App\Storages\YandexDisk\YandexDiskStorageContract;
use Illuminate\Foundation\Bus\PendingDispatch;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\User\User;

trait FileHandlerTrait
{
    protected function getStorage(Nutgram $bot): ?CloudStorage
    {
        $settings = TelegramAccountSettings::whereRelation(
            'telegramAccount',
            'telegram_id',
            '=',
            $bot->userId()
        )->first();

        return $settings?->cloudStorage;
    }

    protected function makeFileHandlerDispatchData(Nutgram $bot, string $fileId): FileHandlerDispatchData
    {
        $storage = $this->getStorage($bot);
        return new FileHandlerDispatchData(
            $fileId,
            $bot->userId(),
            $storage->id
        );
    }

    protected function dispatchJob(Nutgram $bot, string $fileId): PendingDispatch
    {
        $dispatchData = $this->makeFileHandlerDispatchData($bot, $fileId);
        dump($dispatchData->toJson());
        return UploadFileToStorageJob::dispatch($dispatchData->toJson());
    }
}