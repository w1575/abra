<div>
    <table class="table table-primary table-responsive">
        <tr>
            <td>
                {{ __('cloud-storage.id') }}
            </td>
            <td>
                {{ __('cloud-storage.name') }}
            </td>
            <td>
                {{ __('cloud-storage.access_config') }}
            </td>
            <td>
                {{ __('cloud-storage.storage_settings') }}
            </td>
            <td>
                {{ __('common.created_at') }}
            </td>
            <td>
                {{ __('common.updated_at') }}
            </td>
        </tr>

        <?php /** @var \App\Models\CloudStorage[]|\Illuminate\Database\Eloquent\Collection $cloudStorages */ ?>
        @foreach($cloudStorages as $cloudStorage)
            <tr>
                <td>
                    {{ $cloudStorage->id }}
                </td>
                <td>
                    {{ $cloudStorage->name }}
                </td>
                <td>
                    {{ !is_null($cloudStorage->access_config) ? __('cloud-storage.data_set') :  __('cloud-storage.data_not_set') }}
                </td>
                <td>
                    @if($cloudStorage->storage_settings !== null)
                    <table ckass="table">
                        <tr>
                            <td>
                                {{ __('cloud-storage.config.generateFileName') }} :
                                {{ $cloudStorage->storage_settings->generateFileName ? __('common.true') : __('common.false') }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{ __('cloud-storage.config.overwrite') }} :
                                {{ $cloudStorage->storage_settings->overwrite ? __('common.true') : __('common.false') }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{ __('cloud-storage.config.lengthOfGeneratedName') }}
                                : {{ (string)$cloudStorage->storage_settings->lengthOfGeneratedName }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{ __('cloud-storage.config.folder') }}
                                : {{ (string)$cloudStorage->storage_settings->lengthOfGeneratedName }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{ __('cloud-storage.config.subFolderBasedOnType') }}
                                : {{ (string)$cloudStorage->storage_settings->lengthOfGeneratedName }}
                            </td>
                        </tr>
                    </table>
                    @else
                        {{ __('cloud-storage.data_not_set') }}
                    @endif
                </td>
                <td>
                    {{ $cloudStorage->created_at }}
                </td>
                <td>
                    {{ $cloudStorage->updated_at }}
                </td>

            </tr>
        @endforeach
    </table>

    {{ $cloudStorages->links() }}
</div>
