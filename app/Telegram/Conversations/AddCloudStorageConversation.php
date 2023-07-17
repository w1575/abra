<?php

namespace App\Telegram\Conversations;

use App\Data\Storages\AccessConfigs\YandexDiskAccessConfigData;
use App\Data\Storages\Settings\StorageSettingsData;
use App\Enums\Storages\StorageTypeEnum;
use App\Models\CloudStorage;
use App\Models\TelegramAccount;
use Illuminate\Support\Facades\Crypt;
use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\User\User;

class AddCloudStorageConversation extends Conversation
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
        if (empty($name) or mb_strlen($name) < 3) {
            $bot->sendMessage('cloud-storage.bot.invalid_name');
        } else {
            $telegramAccountId = TelegramAccount::whereTelegramId($bot->user()->id)->first()?->id;
            CloudStorage::create([
                'name' => $name,
                'telegram_account_id' => $telegramAccountId,
                'storage_settings' => (new StorageSettingsData())->toJson(),
            ]);
            $bot->sendMessage(__('cloud-storage.bot.enter_storage_type'));
            $bot->sendMessage($this->getStorageList());
            $this->next('enterStorageType');
        }
    }

    protected function getStorageList(): string
    {
        $index = 0;
        $processItem = function(string $carry, $item) use ($index) {
            $index ++;
            return $carry . PHP_EOL . "{$index} : {$item}";
        };

        return array_reduce(StorageTypeEnum::valuesList(), $processItem, '');
    }

    /**
     * @throws InvalidArgumentException
     */
    public function enterStorageType(Nutgram $bot): void
    {
        $index = (int) $bot->message()->text - 1;
        $storageType = StorageTypeEnum::valuesList()[$index] ?? null;
        if ($storageType === null) {
            $bot->sendMessage(__('cloud_storage.bot.storage_type_not_found'));
            return;
        }

        $storage = $this->getUserLatestStorage($bot->user());
        $storage->update([
            'storage_type' => $storageType
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
}
