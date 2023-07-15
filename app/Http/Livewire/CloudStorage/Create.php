<?php

namespace App\Http\Livewire\CloudStorage;

use App\Data\Storages\Settings\StorageSettingsData;
use App\Enums\Storages\StorageTypeEnum;
use App\Models\CloudStorage;
use App\Models\TelegramAccount;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Spatie\LaravelData\Support\Validation\ValidationRuleFactory;

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

    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.cloud-storage.create');
    }

    protected function createValidationRules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:48'],
            'storage_type' => ['required', Rule::in(StorageTypeEnum::valuesList())],
            'storage_settings_overwrite' => ['required', 'boolean'],
            'storage_settings_length_of_generated_name' => ['required', 'int', 'min:8', 'max:64'],
        ];
    }

    public function submit(): void
    {
        $this->validate($this->createValidationRules());

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
