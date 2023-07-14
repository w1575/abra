<?php

namespace Database\Seeders;

use App\Models\CloudStorage;
use App\Models\TelegramAccount;
use Illuminate\Database\Seeder;

class CloudStorageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            CloudStorage::factory()
                ->for(TelegramAccount::factory(), 'telegramAccount')
                ->create()
            ;
        }
    }
}
