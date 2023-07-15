<?php

namespace Database\Factories;

use App\Enums\Storages\StorageTypeEnum;
use App\Models\TelegramAccount;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

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
            'access_config' => json_encode(['token' => Crypt::encrypt(Str::random(32))]),
            'storage_settings' => json_encode([
                'generateFileName' => rand(true, false),
                'overwrite' => rand(true, false),
                'lengthOfGeneratedName' => rand(10, 32),
            ]),
        ];
    }
}
