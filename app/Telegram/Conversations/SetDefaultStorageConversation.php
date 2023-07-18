<?php

namespace App\Telegram\Conversations;

use App\Models\CloudStorage;
use App\Models\TelegramAccount;
use App\Models\TelegramAccountSettings;
use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class SetDefaultStorageConversation extends Conversation
{
    /**
     * @throws InvalidArgumentException
     */
    public function start(Nutgram $bot): void
    {
        /** @var TelegramAccount $account */
        $account = $bot->get('telegramAccount');

        $storages = $account->cloudStorages;

        if ($storages->isEmpty()) {
            $bot->sendMessage(__('cloud-storage.bot.no_storages'));
            $this->end();
            return;
        }

        $list = "";
        $storages->each(function (CloudStorage $item) use (&$list) {
            $list .= "{$item->id} . {$item->name} " . PHP_EOL;
        });

        $bot->sendMessage(__('cloud-storage.bot.set_default_start'));

        $bot->sendMessage($list);
        $this
            ->setSkipMiddlewares(false)
            ->next('setStorage')
        ;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setStorage(Nutgram $bot): void
    {
        $id = (int) $bot->message()->text;

        /** @var TelegramAccount $account */
//        $account = $bot->get('telegramAccount');
        // for some reason middleware not working

        $account = TelegramAccount::whereTelegramId($bot->user()->id)->first();

        $exist = CloudStorage::whereId($id)->whereTelegramAccountId($account->id)->exists();

        if ($exist) {
            $account
                ->telegramAccountSettings()
                ->update([
                    'cloud_storage_id' => $id,
                ])
            ;
            $bot->sendMessage(__('common.success'));
        } else {
            $bot->sendMessage(__('common.data_not_found'));
        }

        $this->end();
    }
}
