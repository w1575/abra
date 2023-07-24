<?php

namespace App\Telegram\Conversations;

use App\Data\Storages\AccessConfigs\YandexDiskAccessConfigData;
use App\Data\Storages\Settings\StorageSettingsData;
use App\Enums\Storages\StorageTypeEnum;
use App\Models\CloudStorage;
use App\Models\TelegramAccount;
use App\Models\TelegramAccountSettings;
use Illuminate\Support\Facades\Crypt;
use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Nutgram\Conversations\InlineMenu;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\User\User;

class AddCloudStorageConversation extends InlineMenu
{
    protected function getUserLatestStorage(User $user): CloudStorage|null
    {
        $telegramAccount = TelegramAccount::whereTelegramId($user->id)->first()->id;
        $query = CloudStorage::query()->latest()->whereTelegramAccountId($telegramAccount);
        return $query->first();
    }

    public function start(Nutgram $bot): void
    {
        $bot->sendMessage(__('cloud-storage.bot.enter_name'));
        $this->next('enterName');
    }

    protected function clearName(string $name): ?string
    {
        return preg_replace('/[^A-Za-z0-9А-Яа-яЁё\-]/', '', $name); // Removes special chars.
    }

    /**
     * @throws InvalidArgumentException
     */
    public function enterName(Nutgram $bot): void
    {
        $name = $bot->message()?->text ?? ' ';

        $name = $this->clearName($name);

        if (empty($name) or mb_strlen($name) < 3) {
            $bot->sendMessage('cloud-storage.bot.invalid_name');
        } else {
            $telegramAccountId = TelegramAccount::whereTelegramId($bot->user()->id)->first()?->id;
            CloudStorage::create([
                'name' => $name,
                'telegram_account_id' => $telegramAccountId,
                'storage_settings' => new StorageSettingsData(),
            ]);

            $menu = $this->menuText(__('cloud-storage.bot.enter_storage_type'));
            foreach (StorageTypeEnum::valuesList() as $storage) {
                $menu->addButtonRow(InlineKeyboardButton::make($storage, callback_data: "{$storage}@setStorageType"));
            }
            $menu->showMenu();
        }
    }

    public function setStorageType(Nutgram $bot): void
    {
        $type = $bot->callbackQuery()->data;
        $storage = $this->getUserLatestStorage($bot->user());
        $storage->update([
            'storage_type' => $type
        ]);
        $bot->sendMessage(__('cloud-storage.bot.access_data_needed'));
        $bot->sendMessage($this->getStorageInstructionText($storage));
        $this->next('setAccessToken');
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setAccessToken(Nutgram $bot): void
    {
        $storage = $this->getUserLatestStorage($bot->user());
        $message = $bot->message()->text;
        if (empty($message)) {
            return;
        }
        $this->setAccessConfig($storage, $message);
        $bot->sendMessage(__('cloud-storage.bot.end_add_conversation'));

        $this->setUserDefaultStorage($storage, $bot->user()->id);

        $this->end();
    }

    protected function getStorageInstructionText(?CloudStorage $storage): string
    {
        return "Инструкция для {$storage->storage_type}"; //TODO: THIS
    }

    private function setAccessConfig(?CloudStorage $storage, string $message): void
    {
        $encrypted = Crypt::encrypt($message);
        $storage->access_config = (new YandexDiskAccessConfigData($encrypted))->toJson();
        $storage->save();
    }

    protected function setUserDefaultStorage(?CloudStorage $storage, int $id): void
    {
        TelegramAccountSettings::whereRelation(
            'telegramAccount',
            'telegram_id',
            '=',
            $id
        )->update([
            'cloud_storage_id' => $storage->id,
        ]);
    }
}
