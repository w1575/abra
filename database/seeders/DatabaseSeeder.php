<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\TelegramAccount;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::factory(2500)->create();

         User::factory()->create([
             'name' => 'TestCommand User',
             'email' => 'test@example.com',
         ]);

         TelegramAccount::factory(5000)->create();
        TelegramAccount::factory()->create([
            'user_id' => (new \App\Models\User)->first()?->id,
        ]);
    }
}
