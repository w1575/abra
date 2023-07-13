<?php

namespace App\Console\Commands\Test\Storage;

use App\Data\Storages\Common\UploadFileData;
use App\Data\Storages\Settings\StorageSettingsData;
use App\Storages\YandexDisk\YandexDiskStorage;
use App\Storages\YandexDisk\YandexDiskStorageContract;
use Illuminate\Console\Command;

class YandexGetListTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:yandex-get-list-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $yaDiskComponent = app(YandexDiskStorageContract::class);

        $yaDiskComponent->setStorageSettings(new StorageSettingsData());

        $uploadFileData = new UploadFileData(
            storage_path('app/public/smirk.jpeg')
        );
        $response = $yaDiskComponent->uploadFile($uploadFileData);

    }
}
