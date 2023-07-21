<?php

namespace App\Telegram\Conversations;

use App\Enums\TelegramAccount\StatusEnum;
use App\Models\BotToken;
use App\Models\TelegramAccount;
use App\Models\TelegramAccountSettings;
use Exception;
use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Nutgram\Conversations\InlineMenu;
use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\User\User;

class StartConversation extends Command
{
    /**
     */
    public function handle(Nutgram $bot): void
    {
        $message = "Привет! По-умолчанию язык системы - русский. Ты можешь изменить его: /set_language";
        $message .= PHP_EOL . "Hello! By default, the system language is Russian. You can change it: /set_language";
        $bot->sendMessage($message);
        $this->createUser($bot->user());

    }

    protected function createUser(User $user): void
    {
        $name = $user->first_name . $user->last_name;

        /** @var TelegramAccount $account */
        $account = TelegramAccount::whereTelegramId($user->id)->first();

        if ($account === null) {
            $account = TelegramAccount::create([
                'telegram_id' => $user->id,
                'username' => $user->username ?? 'UserId' . $user->id,
                'name' => empty($name) ? 'UserId' . $user->id : $name,
                'avatar' => null,
                'token' => null,
                'user_id' => null,
            ]);
        }

        TelegramAccountSettings::firstOrCreate([
            'telegram_account_id' => $account->id,
            'locale' => 'ru',
        ]);
    }
}
