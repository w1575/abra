<?php

namespace App\Providers;

use App\Components\MimeType\GetFileExtensionByMimeMimeType;
use App\Storages\Factory\StorageFactory;
use App\Storages\Factory\StorageFactoryContract;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        StorageFactoryContract::class => StorageFactory::class,
        GetFileExtensionByMimeMimeType::class => GetFileExtensionByMimeMimeType::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
