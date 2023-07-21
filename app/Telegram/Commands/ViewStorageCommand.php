<?php

namespace App\Telegram\Commands;

use App\Models\CloudStorage;
use App\Models\TelegramAccount;
use App\Telegram\Traits\TelegramAccountTrait;
use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Nutgram\Conversations\InlineMenu;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

class ViewStorageCommand extends InlineMenu
{
    use TelegramAccountTrait;

    protected string $command = 'view_storage';

    protected ?string $description = 'Просмотр хранилища.';

    /**
     * @throws InvalidArgumentException
     */
    public function start(Nutgram $bot): void
    {
        $telegramAccount = $this->getTelegramAccount($bot);
        $menu = $this->menuText(__('telegram.storage.view.list'));
        $menu->clearButtons();

        /** @var CloudStorage $storage */
        foreach ($telegramAccount->cloudStorages as $storage) {
            $menu->addButtonRow(InlineKeyboardButton::make(text: $storage->name, callback_data: "{$storage->id}@viewStorage"));
        }

        $menu->showMenu();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function viewStorage(Nutgram $bot): void
    {
        $id = $bot->callbackQuery()->data;

        $account = $this->getTelegramAccount($bot);

        if ($id !== null) {
            $storage = CloudStorage::whereTelegramAccountId($account->id)->whereId($id)->first();

            $message = __('telegram.storage.view.info', [
                "name" => $storage->name,
                "type" => $storage->storage_type,
                "default" => $storage->getIsDefault() ? "+" : "-",
                "accessSet" => $storage->access_config !== null ? "+" : "-",
                "generateFileName" => $storage->storage_settings->generateFileName,
                "overwrite" => $storage->storage_settings->overwrite,
                "lengthOfGeneratedName" => $storage->storage_settings->lengthOfGeneratedName ? "+" : "-",
                "folder" => $storage->storage_settings->folder,
                "subFolderBasedOnType" => $storage->storage_settings->subFolderBasedOnType,
            ]);

            $menu = $this->menuText($message);
            $menu->clearButtons();
            $menu->addButtonRow(
                InlineKeyboardButton::make(
                    text: __('common.edit'),
                    callback_data: "{$storage->id}@editStorage"
                )
            );

            if ($storage->getIsDefault() === false) {
                $menu->addButtonRow(
                    InlineKeyboardButton::make(
                        text: __('telegram.storage.set_default'),
                        callback_data: "{$storage->id}@setDefault"
                    )
                );
            }

            $menu->showMenu();
        } else {
            $bot->sendMessage(__('telegram.storage.view.no_storages'));
            $this->end();
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    public function editStorage(Nutgram $bot): void
    {
        $id = (int) $bot->callbackQuery()->data;
        $telegramAccount = $this->getTelegramAccount($bot);
        $storage = CloudStorage::query()->whereId($id)->whereTelegramAccountId($telegramAccount->id)->first();
        $menu = $this->menuText(__('common.edit'));
        $menu->clearButtons();

        $menu->addButtonRow(
            InlineKeyboardButton::make(
                __('cloud-storage.name'),
                callback_data: "$storage->id@editName"
            ),
            InlineKeyboardButton::make(
                __('cloud-storage.storage_type'),
                callback_data: "$storage->id@editStorageType"
            ),
        );

        $menu->addButtonRow(
            InlineKeyboardButton::make(
                __('cloud-storage.config.generateFileName'),
                callback_data: "$storage->id@editGenerateFileName"
            ),
            InlineKeyboardButton::make(
                __('cloud-storage.config.overwrite'),
                callback_data: "$storage->id@editOverwrite"
            ),
        );
        $menu->addButtonRow(
            InlineKeyboardButton::make(
                __('cloud-storage.config.lengthOfGeneratedName'),
                callback_data: "$storage->id@editLengthOfGeneratedName"
            ),
            InlineKeyboardButton::make(
                __('cloud-storage.config.folder'),
                callback_data: "$storage->id@editFolder"
            ),
        );

        $menu->addButtonRow(
            InlineKeyboardButton::make(
            __('cloud-storage.config.folder'),
            callback_data: "$storage->id@editSubFolderBasedOnType"
        ));

        $this->addBackButton($menu);
        $menu->showMenu();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function editName(Nutgram $bot): void
    {
        $storageId = (int) $bot->callbackQuery()->data;
        $text = $bot->message()->text;
        $bot->answerCallbackQuery(text: $text);
        $menu = $this->menuText(__('common.new_name'));
        $menu->clearButtons();

        $menu->addButtonRow(
            InlineKeyboardButton::make(text: __('common.back'), callback_data: "{$storageId}@editStorage")
        )->orNext("$storageId@saveNewName");

        $menu->showMenu();

        $bot->sendMessage(text: 'cloud-storage.bot.enter_name');
    }

    public function saveNewName(Nutgram $bot): void
    {
        $storageId = (int) $bot->callbackQuery()?->data;
        $bot->answerCallbackQuery(text: $storageId);

        $message = $bot->message()->text;
        if (mb_strlen($message) <= 3) {
            $bot->sendMessage(__('cloud-storage.invalid_name'));
            return;
        }

        $bot->answerCallbackQuery(text: __('common.success'));
    }

    public function editStorageType(Nutgram $bot): void
    {

    }
    public function editGenerateFileName(Nutgram $bot): void
    {

    }
    public function editOverwrite(Nutgram $bot): void
    {

    }
    public function editLengthOfGeneratedName(Nutgram $bot): void
    {

    }
    public function editFolder(Nutgram $bot): void
    {

    }
    public function editSubFolderBasedOnType(Nutgram $bot): void
    {

    }

    public function setDefault(Nutgram $bot): void
    {
        $id = (int) $bot->callbackQuery()->data;
        $this
            ->getTelegramAccount($bot)
            ->telegramAccountSettings
            ->update([
                'cloud_storage_id' => $id,
            ])
        ;

        $bot->answerCallbackQuery(text: __('common.success'));
    }

    protected function addBackButton(ViewStorageCommand $menu): void
    {
        $menu->addButtonRow(InlineKeyboardButton::make(
            text: __('telegram.storage.back_to_list'),
            callback_data: 'back@start'
        ));
    }

}
