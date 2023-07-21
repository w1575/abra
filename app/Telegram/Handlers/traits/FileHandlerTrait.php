<?php

namespace App\Telegram\Handlers\traits;

use App\Data\Telegram\FileHandlerDispatchData;
use App\Enums\Storages\StorageTypeEnum;
use App\Models\CloudStorage;
use App\Storages\StorageContract;
use App\Storages\YandexDisk\YandexDiskStorageContract;
use SergiX44\Nutgram\Telegram\Types\User\User;

trait FileHandlerTrait
{
    public function dispatchJob(FileHandlerDispatchData $data, User $user)
    {
        $handlerData = new FileHandlerDispatchData();
    }

    protected function getStorageComponent(CloudStorage $storage): ?StorageContract
    {
        switch ($storage->storage_type) {
            case StorageTypeEnum::YandexDisk->value:
                return app(YandexDiskStorageContract::class);
        }

        return null;
    }
}