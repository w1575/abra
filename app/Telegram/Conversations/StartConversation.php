<?php

namespace App\Telegram\Conversations;

use App\Enums\TelegramAccount\StatusEnum;
use App\Models\BotToken;
use App\Models\TelegramAccount;
use App\Models\TelegramAccountSettings;
use Exception;
use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\User\User;

class StartConversation extends Conversation
{
    /**
     * @throws InvalidArgumentException
     */
    public function start(Nutgram $bot): void
    {
        $message = "Привет! По-умолчанию язык системы - русский. Ты можешь изменить его ";
        $message .= "отправив команду /set_language";

        $message .= PHP_EOL . "Для работы системы необходимо установить код приглашения. Команда /set_token";

        $bot->sendMessage($message);

        $message = PHP_EOL . "Hello! By default, the system language is Russian. You can change it";
        $message .= " by sending a command /set_language";
        $message .= PHP_EOL . "For the system to work, you need to set the invitation code. Command /set_token";
        $bot->sendMessage($message);

        $this->createUser($bot->user());
        $this->end();
    }

    protected function createUser(User $user): void
    {
        $name = $user->first_name . $user->last_name;

        $account = TelegramAccount::firstOrCreate([
            'telegram_id' => $user->id,
            'username' => $user->username ?? 'UserId' . $user->id,
            'name' => empty($name) ? 'UserId' . $user->id : $name,
            'avatar' => '',
            'token' => null,
            'user_id' => null,
            'status' => StatusEnum::Active->value,
        ]);

        TelegramAccountSettings::create([
            'telegram_account_id' => $account->id,
            'locale' => 'ru',
        ]);
    }
}
