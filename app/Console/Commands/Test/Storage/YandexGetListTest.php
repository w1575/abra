<?php

namespace App\Console\Commands\Test\Storage;

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
    public function handle()
    {
        $yaDiskComponent = app(YandexDiskStorageContract::class);
        $response = $yaDiskComponent->getFilesList('/');
        dd($response->embedded->items->items());

    }
}
