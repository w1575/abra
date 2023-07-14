<?php

namespace Database\Factories;

use App\Enums\Storages\StorageTypeEnum;
use App\Models\TelegramAccount;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CloudStorage>
 */
class CloudStorageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'telegram_account_id' => (new TelegramAccount())->firstOrFail()?->id,
            'storage_type' => StorageTypeEnum::YandexDisk->value,
            'storage_settings' => null,
            'storage_config' => null,
        ];
    }
}
