<?php

namespace App\Telegram\Commands;

use App\Data\ConversationSteps\EditStorageConversationData;
use App\Enums\Storages\StorageTypeEnum;
use App\Models\CloudStorage;
use App\Models\ConversationStep;
use App\Telegram\Traits\TelegramConversationTrait;
use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Nutgram\Conversations\InlineMenu;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;

/**
 * TODO: Refactor this shit
 */
class ViewStorageCommand extends InlineMenu
{
    use TelegramConversationTrait;

    public const CONVERSATION_STEP_NAME = 'ViewStorageCommand';

    protected string $command = 'view_storage';

    protected ?string $description = 'Просмотр хранилища.';

    protected function makeViewStorageMenu(CloudStorage $storage): self
    {
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

        $this->closeMenu();
        $this->menuText($message);
        $this->clearButtons();
        $this->addButtonRow(
            InlineKeyboardButton::make(
                text: __('common.edit'),
                callback_data: "{$storage->id}@editStorage"
            )
        );

        if ($storage->getIsDefault() === false) {
            $this->addButtonRow(
                InlineKeyboardButton::make(
                    text: __('telegram.storage.set_default'),
                    callback_data: "{$storage->id}@setDefault"
                )
            );
        }

        $this->addBackButton();

        return $this;
    }

    protected function getStorageByIdAndAccount(int $storageId, int $accountId): ?CloudStorage
    {
        return CloudStorage::query()
            ->whereId($storageId)
            ->whererelation('telegramAccount', 'telegram_id', '=', $accountId)
            ->first()
        ;
    }

    protected function getStorageById(Nutgram $bot, int $storageId): ?CloudStorage
    {
        $account = $this->getTelegramAccount($bot);

        return $this->getStorageByIdAndAccount($storageId, $account->telegram_id);
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function makeMainMenu(Nutgram $bot)
    {
        $this->menuText(__('telegram.storage.view.list'));
        $this->clearButtons();

        $telegramAccount = $this->getTelegramAccount($bot);

        /** @var CloudStorage $storage */
        foreach ($telegramAccount->cloudStorages as $storage) {
            $this->addButtonRow(InlineKeyboardButton::make(text: $storage->name, callback_data: "{$storage->id}@viewStorage"));
        }

        $this->showMenu();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function start(Nutgram $bot): void
    {
        $this->makeMainMenu($bot);

        $this->logMemoryUsage('start');
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function makeEditMenu(Nutgram $bot, CloudStorage $storage): void
    {
        $storage->refresh();

        $this->clearButtons();

        $this->menuText(__('common.edit') . " : $storage->name");

        $step = $this->getConversationStep($bot);

        $data = $step->step_data !== null
            ? EditStorageConversationData::from($step->step_data)
            : new EditStorageConversationData($storage->id, static::CONVERSATION_STEP_NAME)
        ;

        $data->cloud_storage_id = $storage->id;
        $data->step_data = static::CONVERSATION_STEP_NAME;

        $step->step_data = $data;

        $step->update([
            "step_data" => $data->toJson(),
        ]);

        $step->fresh();

        $this->addButtonRow(
            InlineKeyboardButton::make(
                __('cloud-storage.name'),
                callback_data: "$storage->id@editName"
            ),
            InlineKeyboardButton::make(
                __('cloud-storage.storage_type'),
                callback_data: "$storage->id@editStorageType"
            ),
        );

        $this->addButtonRow(
            InlineKeyboardButton::make(
                __('cloud-storage.config.folder'),
                callback_data: "$storage->id@newUploadDir"
            ),
        );

        $this->addButtonRow(
            InlineKeyboardButton::make(
                __('cloud-storage.config.lengthOfGeneratedName'),
                callback_data: "$storage->id@editLengthOfGeneratedName"
            ),
        );

        $basedOnType = $storage
            ->storage_settings
            ->subFolderBasedOnType
            ? __('common.true')
            : __('common.false')
        ;

        $generateName = $storage
            ->storage_settings
            ->generateFileName
            ? __('common.true')
            : __('common.false')
        ;

        $overwrite = $storage
            ->storage_settings
            ->overwrite
            ? __('common.true')
            : __('common.false')
        ;

        $generateName = __('cloud-storage.config.generateFileName') . " : $generateName";

        $this->addButtonRow(
            InlineKeyboardButton::make(
                $generateName,
                callback_data: "$storage->id@editGenerateFileName"
            )
        );

        $overwrite = __('cloud-storage.config.overwrite') . " : $overwrite";

        $this->addButtonRow(
            InlineKeyboardButton::make(
                $overwrite,
                callback_data: "$storage->id@overwriteSet"
            ),
        );

        $this->addButtonRow(
            InlineKeyboardButton::make(
                __('cloud-storage.config.subFolderBasedOnType') . " : $basedOnType",
                callback_data: "$storage->id@editSubFolderBasedOnType"
            )
        );

        $this->addBackButton();
        $this->showMenu();
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
            $this->makeViewStorageMenu($storage)->showMenu();
        } else {
            $bot->sendMessage(__('telegram.storage.view.no_storages'));
            $this->end();
        }

        $this->logMemoryUsage('viewStorage');
    }

    /**
     * @throws InvalidArgumentException
     */
    public function editStorage(Nutgram $bot): void
    {
        $id = (int) $bot->callbackQuery()?->data;

        $telegramAccount = $this->getTelegramAccount($bot);
        $storage = CloudStorage::query()->whereId($id)->whereTelegramAccountId($telegramAccount->id)->first();

        $this->makeEditMenu($bot, $storage);

        $this->logMemoryUsage('editStorage');
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
        );

        $currentConversation = $this->getConversationStep($bot);

        $conversationData = new EditStorageConversationData(
            $storageId,
            static::CONVERSATION_STEP_NAME
        );

        $currentConversation->update([
            'step_data' => $conversationData->toJson(),
        ]) ;

        $bot->sendMessage(text: __('cloud-storage.bot.enter_name'));

        $this->next('saveNewName');

        $this->logMemoryUsage('editName');
    }

    /**
     * @throws InvalidArgumentException
     */
    public function saveNewName(Nutgram $bot): void
    {
        $message = $bot->message()->text;
        if (mb_strlen($message) <= 3) {
            $bot->sendMessage(__('cloud-storage.invalid_name'));
            return;
        }

        $menu = $this->menuText(__('common.new_name') . " : $message");
        $menu->clearButtons();
        $menu->closeMenu();

        $conversation = $this->getConversationStep($bot);

        $conversationStep = EditStorageConversationData::from($conversation->step_data);
        $cloudStorage = CloudStorage::query()->whereId($conversationStep->cloud_storage_id)->first();

        if ($cloudStorage === null) {
            $this->next('start');
            return;
        }

        $cloudStorage->update(['name' => $message]);

        $this->setCallbackQueryOptions([
            'data' => $cloudStorage->id,
        ]);

        $conversation->delete();

        $menu->addButtonRow(InlineKeyboardButton::make(text: __('common.back'), callback_data: "{$cloudStorage->id}@editStorage"));
        $this->addBackButton();
        $menu->showMenu();

        $this->logMemoryUsage('saveNewName');
    }

    /**
     * @throws InvalidArgumentException
     */
    public function editStorageType(Nutgram $bot): void
    {
        $storageId = (int) $bot->callbackQuery()?->data;

        $storage = $this->getStorageByIdAndAccount($storageId, $bot->userId());

        if ($storage === null) {
            $this->end();
            return;
        }

        $listOfTypes = StorageTypeEnum::valuesList();
        $listOfTypes[] = "test";

        $this->clearButtons();

        $this->menuText(__('cloud-storage.bot.select_storage_type'));

        $this->getConversationStep($bot)
            ->update([
                'step_data' => (new EditStorageConversationData($storageId, 'setStorageType'))->toJson(),
            ])
        ;

        foreach ($listOfTypes as $type) {
            $this->addButtonRow(
                InlineKeyboardButton::make(
                    text: $type,
                    callback_data: "$type@setStorageType"
                )
            );
        }

        $this->addBackButton();
        $this->showMenu();

        $this->logMemoryUsage('editStorageType');
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setStorageType(Nutgram $bot): void
    {
        $storageType = $bot->callbackQuery()->data;

        $conversationStep = $this->getConversationStep($bot);
        $stepData = EditStorageConversationData::from($conversationStep->step_data);
        $storageId = $stepData->cloud_storage_id;
        $storage = $this->getStorageByIdAndAccount($storageId, $bot->userId());

        if ($storage === null) {
            $bot->answerCallbackQuery(text: __('common.data_not_found'));
            $this->makeMainMenu($bot);
        } else {
            $bot->answerCallbackQuery(text: __('common.success'));

            $storage->update([
                'storage_type' => $storageType,
            ]);

            $this->makeEditMenu($bot, $storage);
        }

        $this->logMemoryUsage('setStorageType');
    }

    protected function getConversationStepData(Nutgram $bot): ?EditStorageConversationData
    {
        $step = $this->getConversationStep($bot);

        if ($step === null) {
            return null;
        }

        return EditStorageConversationData::from($step->step_data);
    }

    protected function addBackToStorageButton(Nutgram $bot, int $storageId): void
    {
        $this->addButtonRow(
            InlineKeyboardButton::make(
                __('cloud-storage.back_to_storage'),
                callback_data: "$storageId@viewStorage",
            )
        );
    }

    public function editGenerateFileName(Nutgram $bot): void
    {
        $stepData = $this->getConversationStepData($bot);

        $storage = $this->getStorageById($bot, $stepData->cloud_storage_id);
        $currentVal = $storage->storage_settings->generateFileName;
        $storage->storage_settings->generateFileName = !$currentVal;

        $storage->save();

        $bot->answerCallbackQuery(text: __('common.success'));

        $this->makeEditMenu($bot, $storage);

        $this->logMemoryUsage('editGenerateFileName');
    }

    public function generateFileNameSet(Nutgram $bot): void
    {
        $value = $bot->callbackQuery()->data === 'true';

        $storageId = $this->getConversationStepData($bot)->cloud_storage_id;
        $storage = $this->getStorageById($bot, $storageId);

        $storage->storage_settings->generateFileName = $value;

        $storage->save();

        $bot->answerCallbackQuery(text: __('common.success'));
    }

    public function overwriteSet(Nutgram $bot): void
    {
        $stepData = $this->getConversationStepData($bot);

        $storage = $this->getStorageById($bot, $stepData->cloud_storage_id);
        $currentVal = $storage->storage_settings->overwrite;
        $storage->storage_settings->overwrite = !$currentVal;

        $storage->save();

        $bot->answerCallbackQuery(text: __('common.success'));

        $this->makeEditMenu($bot, $storage);

        $this->logMemoryUsage('editGenerateFileName');
    }

    public function editLengthOfGeneratedName(Nutgram $bot): void
    {
        $this->logMemoryUsage('editLengthOfGeneratedName');
    }

    /**
     * @throws InvalidArgumentException
     */
    public function editSubFolderBasedOnType(Nutgram $bot): void
    {
        $stepData = $this->getConversationStepData($bot);

        $storage = $this->getStorageById($bot, $stepData->cloud_storage_id);
        $currentVal = $storage->storage_settings->subFolderBasedOnType;
        $storage->storage_settings->subFolderBasedOnType = !$currentVal;

        $storage->save();

        $bot->answerCallbackQuery(text: __('common.success'));

        $this->makeEditMenu($bot, $storage);

        $this->logMemoryUsage('editGenerateFileName');
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

        $this->makeViewStorageMenu($this->getStorageById($bot, $id));

        $bot->answerCallbackQuery(text: __('common.success'));
    }

    protected function addBackButton(): self
    {
        $this->addButtonRow(InlineKeyboardButton::make(
            text: __('telegram.storage.back_to_list'),
            callback_data: 'back@start'
        ));

        return $this;
    }

    protected function logMemoryUsage(string $step): void
    {
        $size = memory_get_usage(true);
        $unit=array('b','kb','mb','gb','tb','pb');
        $memoryUsed = @round($size/pow(1024, ($i=floor(log($size, 1024)))), 2).' '.$unit[$i];
        file_put_contents(storage_path('/app/usage'), "$step : $memoryUsed" . PHP_EOL, FILE_APPEND);
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

    /**
     * @throws InvalidArgumentException
     */
    public function newUploadDir(Nutgram $bot): void
    {
        $this->clearButtons();

        $storage = $this->getStorageFromConversationStep($bot);

        $bot->sendMessage(__('cloud-storage.bot.enter_new_upload_dir', [
            'folder' => $storage->storage_settings->folder])
        );

        $this->next('saveNewUploadDir');

        $this->logMemoryUsage('editName');
    }

    /**
     * @throws InvalidArgumentException
     */
    public function saveNewUploadDir(Nutgram $bot): void
    {
        $name = $bot->message()->text;

        if (!str_starts_with($name, '\\')) {
            $bot->sendMessage(__('cloud-storage.bot.name_must_start_with_slash'));
            return;
        }

        $name = str_replace($name, '\\', '/');

        $storage = $this->getStorageFromConversationStep($bot);
        $storage->storage_settings->folder = $name;
        $storage->save();
        $this->getConversationStep($bot)->delete();
        $bot->sendMessage(__('common.success'));

        $this->closeMenu();
        $this->clearButtons();

        $this->makeEditMenu($bot, $storage);
    }
}
