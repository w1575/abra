<?php

namespace App\Providers;

use App\Storages\YandexDisk\YandexDiskStorage;
use App\Storages\YandexDisk\YandexDiskStorageContract;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public array $bindings = [
        YandexDiskStorageContract::class => YandexDiskStorage::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->when(YandexDiskStorage::class)
            ->needs(ClientInterface::class)
            ->give(
                fn (Application $app) => new Client([
                    'base_uri' => 'https://cloud-api.yandex.net/v1/disk/resources',
                ])
            )
        ;
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
