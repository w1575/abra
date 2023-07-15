<?php

namespace App\Http\Livewire\CloudStorage;

use App\Data\Storages\Settings\StorageSettingsData;
use App\Enums\Storages\StorageTypeEnum;
use App\Models\CloudStorage;
use App\Models\TelegramAccount;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class Create extends Component
{
    public string $name;

    public string $storage_type;

    public bool $storage_settings_overwrite = false;

    public bool $storage_settings_generate_file_name = false;

    public int $storage_settings_length_of_generated_name = 32;

    /**
     * @var string[]
     */
    public array $storageTypes = [];

    public function __construct($id = null)
    {
        $this->storageTypes = StorageTypeEnum::valuesList();
        $this->storage_type = StorageTypeEnum::valuesList()[0];
        parent::__construct($id);
    }

    public function render(): View|Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.cloud-storage.create');
    }

    public function submit(): void
    {
        $storageSettings = new StorageSettingsData();
        $storageSettings->overwrite = $this->storage_settings_overwrite;
        $storageSettings->generateFileName = $this->storage_settings_generate_file_name;
        $storageSettings->lengthOfGeneratedName = $this->storage_settings_length_of_generated_name;

        CloudStorage::create([
            'name' => $this->name,
            'storage_type' => $this->storage_type,
            'storage_settings' => $storageSettings,
            'telegram_account_id' => TelegramAccount::firstOrFail()->id, //TODO: current user account
        ]);
    }
}
