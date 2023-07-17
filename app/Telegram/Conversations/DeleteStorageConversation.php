<?php

namespace App\Telegram\Conversations;

use App\Models\CloudStorage;
use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class DeleteStorageConversation extends Conversation
{
    public function start(Nutgram $bot): void
    {
        $storages = CloudStorage::query()
            ->whereRelation(
                'telegramAccount',
                'telegram_id',
                $bot->user()->id
            )
            ->get()
        ;

        $list = "";

        $storages->each(function (CloudStorage $item, $key) use (&$list) {
            $list .= PHP_EOL . "{$item->id} : {$item->name}";
        });

        $bot->sendMessage($list);
        $this->next('secondStep');
    }

    /**
     * @throws InvalidArgumentException
     */
    public function secondStep(Nutgram $bot): void
    {
        $id = (int) $bot->message()->text;

        $count = CloudStorage::query()
            ->select('cloud_storages.id')
            ->whereRelation(
                'telegramAccount',
                'telegram_id',
                $bot->user()->id
            )
            ->whereId($id)
            ->delete()
        ;

        if ($count < 1) {
            $bot->sendMessage(__('common.data_not_found'));
        } else {
            $bot->sendMessage(__('common.success'));
        }
        $this->end();
    }
}
