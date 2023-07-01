<?php

namespace Database\Factories;

use App\Enums\TelegramAccount\StatusEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TelegramAccount>
 */
class TelegramAccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'telegram_id' => fake()->numberBetween(1, 100000000),
            'username' => fake()->unique()->userName,
            'name' => fake()->unique()->userName,
            'avatar' => fake()->imageUrl(),
            'token' => fake()->linuxPlatformToken,
            'user_id' => User::doesntHave('telegramAccounts')->first()?->id,
            'status' => function() {
                $values = StatusEnum::valuesList();
                return $values[array_rand($values)];
            },
        ];
    }
}
