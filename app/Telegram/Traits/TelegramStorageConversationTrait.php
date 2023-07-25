<?php

namespace App\Telegram\Traits;

use App\Data\ConversationSteps\EditStorageConversationData;
use App\Models\CloudStorage;
use App\Models\ConversationStep;
use App\Models\TelegramAccount;
use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Nutgram\Nutgram;

trait TelegramStorageConversationTrait
{
    public function getTelegramAccount(Nutgram $bot): ?TelegramAccount
    {
        return $bot->get('telegramAccount') ?? TelegramAccount::whereTelegramId($bot->userId())->first();
    }

    protected function getConversationStep(Nutgram $bot): ?ConversationStep
    {
        $account = $this->getTelegramAccount($bot);
        return ConversationStep::query()
            ->firstOrCreate([
                'conversation_name' => static::CONVERSATION_STEP_NAME,
                'telegram_account_id' => $account->id,
            ])
        ;
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function getStorageWhereUserHasAccess(Nutgram $bot, int $storageId): CloudStorage
    {
        $storage = CloudStorage::query()
            ->whereTelegramId($bot->userId())
            ->whereId($storageId)
            ->first()
        ;

        if ($storage === null) {
            $bot->answerCallbackQuery(text: __('cloud-storage.bot.storage_not_found'));
            $this->end();
        }

        return $storage;
    }

    protected function getConversationStepData(Nutgram $bot): ?EditStorageConversationData
    {
        $step = $this->getConversationStep($bot);

        if ($step === null) {
            return null;
        }

        return EditStorageConversationData::from($step->step_data ?? json_encode([]));
    }

    /**
     * TODO: use this where possible
     * @throws InvalidArgumentException
     */
    protected function getStorageFromRequestAndSaveStepData(Nutgram $bot): CloudStorage
    {
        $storageId = (int) $bot->callbackQuery()->data;
        $currentConversation = $this->getConversationStep($bot);
        $conversationData = new EditStorageConversationData(
            $storageId,
            static::CONVERSATION_STEP_NAME
        );

        $currentConversation->update([
            'step_data' => $conversationData->toJson(),
        ]);

        return $this->getStorageWhereUserHasAccess($bot, $storageId);
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function getStorageFromConversationStep(Nutgram $bot): CloudStorage
    {
        $data = $this->getConversationStepData($bot);

        return $this->getStorageWhereUserHasAccess($bot, $data->cloud_storage_id);
    }
}