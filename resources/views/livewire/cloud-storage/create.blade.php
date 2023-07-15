<div class="bd-example">
    <form wire:submit.prevent="submit" class="form">

        <label class="form-label">
            {{ __('cloud-storage.name') }}
        </label>
        <input class="form-control" type="text" wire:model="name" />
        @error('name') <span class="text-danger">{{ $message }}</span> @enderror

        <hr class="hr">

        <label class="form-label"> {{ __('cloud-storage.storage_type') }} </label>
        <select required class="form-select" wire:model="storage_type">
            @foreach($storageTypes as $storageType)
                <option selected value="{{ $storageType }}"> {{ $storageType }} </option>
            @endforeach
        </select>
        @error('storage_type') <span class="text-danger">{{ $message }}</span> @enderror

        <hr class="hr">
        <label>
            <input class="form-check-input" type="checkbox" wire:model="storage_settings_overwrite" {{ $storage_settings_overwrite ? 'checked' : null }}>
            {{ __('cloud-storage.config.overwrite') }}
        </label>
        @error('storage_settings_overwrite') <span class="text-danger">{{ $message }}</span> @enderror
        <hr class="hr">

        <label>
            <input class="form-check-input" type="checkbox" wire:model="storage_settings_generate_file_name" {{ $storage_settings_overwrite ? 'checked' : null }}>
            {{ __('cloud-storage.config.generateFileName') }}
        </label>

        @error('storage_settings_overwrite') <span class="text-danger">{{ $message }}</span> @enderror
        <hr class="hr">

        <label class="form-label">
            {{ __('cloud-storage.config.lengthOfGeneratedName') }}
        </label>
        <input class="form-control" type="number" wire:model="storage_settings_length_of_generated_name" />
        @error('storage_settings_length_of_generated_name') <span class="text-danger">{{ $message }}</span> @enderror
        <hr class="hr">
        <button class="btn btn-success" type="submit"> {{__('common.create')}} </button>
    </form>
</div>
