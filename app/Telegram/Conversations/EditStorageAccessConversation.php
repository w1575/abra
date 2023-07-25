<?php

namespace App\Telegram\Conversations;

use App\Data\ConversationSteps\EditStorageConversationData;
use App\Data\Storages\AccessConfigs\YandexDiskAccessConfigData;
use App\Enums\Storages\StorageTypeEnum;
use App\Models\CloudStorage;
use App\Telegram\Traits\TelegramStorageConversationTrait;
use Illuminate\Support\Facades\Crypt;
use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Nutgram\Conversations\InlineMenu;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;

class EditStorageAccessConversation extends InlineMenu
{
    use TelegramStorageConversationTrait;

    public const CONVERSATION_STEP_NAME = "edit_storage_access";

    /**
     * @throws InvalidArgumentException
     */
    protected function makeStoragesListMenu(Nutgram $bot): void
    {
        $account = $this->getTelegramAccount($bot);

        $this->clearButtons();
        $this->closeMenu();

        $this->menuText(__('telegram.storage.view.list'));

        if ($account->cloudStorages->isEmpty()) {
            $this->closeMenu();
            $bot->sendMessage(__('common.not_found'));
            $this->end();
        } else {
            foreach ($account->cloudStorages as $cloudStorage) {
                $this->addButtonRow(InlineKeyboardButton::make(text: $cloudStorage->name, callback_data: "{$cloudStorage->id}@storageAccessSettings"));
            }
            $this->showMenu();
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    public function start(Nutgram $bot): void
    {
        $this->makeStoragesListMenu($bot);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function storageAccessSettings(Nutgram $bot): void
    {
        $storageId = $bot->callbackQuery()->data;
        $storage = $this->getStorageWhereUserHasAccess($bot, $storageId);
        switch ($storage->storage_type) {
            case StorageTypeEnum::YandexDisk->value:
                $this->makeYandexEditMenu($bot, $storage);
                break;
            default:
                $this->closeMenu();
                $this->end();
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function makeYandexEditMenu(Nutgram $bot, CloudStorage $storage)
    {
        $this->menuText(__('common.edit') . " : {$storage->name}");

        $this->clearButtons();

        $this->addButtonRow(
            InlineKeyboardButton::make(__('cloud-storage.access_settings.debugToken'), callback_data: "{$storage->id}@editYandexToken")
        );


        $this->showMenu();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function editYandexToken(Nutgram $bot): void
    {
        $storageId = (int) $bot->callbackQuery()->data;
        $storage = $this->getStorageWhereUserHasAccess($bot, $storageId);

        $this->clearButtons();
        $this->closeMenu();

        $bot->sendMessage(
            __('cloud-storage.access_settings.enter_new_token') . " : {$storage->name}"
        );

        $step = $this->getConversationStep($bot);
        $data = EditStorageConversationData::from($step->step_data ?? json_encode([])); // ->storage_id = $storageId
        $data->cloud_storage_id = $storageId;
        $step->step_data = $data->toJson();
        $step->save();

        $this->next('setYandexToken');
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setYandexToken(Nutgram $bot): void
    {
        $token = $bot->message()->text;

        if (mb_strlen($token) < 58) { // looks like all tokens has this length
            $bot->sendMessage(__('cloud-storage.access_settings.debugToken_too_short'));
            return;
        }

        $token = Crypt::encryptString($token);

        $storage = $this->getStorageFromConversationStep($bot);
        $accessConfig = $storage->access_config ?? new YandexDiskAccessConfigData();
        $accessConfig->debugToken = $token;
        $storage->access_config = $accessConfig;
        $storage->save();
        $bot->sendMessage(__('common.success'));
        $this->makeYandexEditMenu($bot, $storage);
    }
}
