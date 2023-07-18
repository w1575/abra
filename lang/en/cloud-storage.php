<?php

return [
    'id' => 'ID',
    'name' => 'Name',
    'access_config' => 'Access',
    'storage_settings' => 'Settings',
    'storage_type' => 'Storage type',

    'data_set' => 'Data set',
    'data_not_set' => 'Data     not set',

    'config' => [
        'generateFileName' => 'Generate file name',
        'overwrite' => 'Overwrite',
        'lengthOfGeneratedName' => 'Length of generated name',
        'folder' => 'Директория для загрузки',
        'subFolderBasedOnType' => 'Загружать в подпапку с именем типа файла',

        'choice_storage' => 'Выберите хранилище.',
        'wrong_storage' => 'Хранилище не найдено, либо нет доступа',
    ],

    'bot' => [
        'enter_name' => 'Enter a name for the storage',
        'choice_type' => 'Select storage type',
        'invalid_name' => 'The name cannot contain special characters only or be empty (minimum 3 characters)',
        'enter_storage_type' => 'Enter cloud storage type',
        'storage_type_not_found' => 'Storage type not found',
        'access_data_needed' => 'You must enter data to access the storage',
        'end_add_conversation' => 'The token has been set. Now you can try uploading your first file.',

        'choice_storage' => 'Select storage.',
        'wrong_storage' => 'Storage not found or access denied',

        'set_default_start' => 'Enter the ID of the vault you want to use by default.',
        'no_storages' => 'You have no storages',
    ],
];