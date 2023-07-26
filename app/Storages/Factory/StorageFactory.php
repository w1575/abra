<?php

namespace App\Storages\Factory;

use App\Enums\Storages\StorageTypeEnum;
use App\Models\CloudStorage;
use App\Storages\Exceptions\UnknownStorageTypeException;
use App\Storages\StorageContract;
use App\Storages\YandexDisk\YandexDiskStorage;
use GuzzleHttp\Client;

class StorageFactory implements StorageFactoryContract
{
    /**
     * @throws UnknownStorageTypeException
     */
    public function make(CloudStorage $cloudStorage): StorageContract
    {
        switch ($cloudStorage->storage_type) {
            case StorageTypeEnum::YandexDisk->value:
                $storageComponent =  new YandexDiskStorage(new Client([
                    'base_uri' => 'https://cloud-api.yandex.net/v1/disk/resources',
                ]));
                $storageComponent->setStorageSettings($cloudStorage->storage_settings);
                $storageComponent->setAccessConfig($cloudStorage->access_config);
                return $storageComponent;
            default:
                throw new UnknownStorageTypeException();
        }
    }
}