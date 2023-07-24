<?php

return [
    'start_command' => [
        'need_set_the_token' => 'You need to set the token.',
        'try_again' => 'Try again.',
        'token_in_use' => 'Token already in use.',
        'token_set' => 'The token has been successfully installed. Now you can use the bot!',
    ],
    'language_been_set' => 'Language has been set',
    'on_message' => [
        'start_processing' => 'I\'m starting data processing.',
    ],
    'storage' => [
        'set_default' => 'Set default',
        'back_to_list' => 'Back to the storages list',
        'view' => [
            'list' => 'List of Your storages',
            'pick' => 'Select Storage',
            'info' => 'Info about storage : '
                . PHP_EOL . 'Name: :Name'
                . PHP_EOL . 'Type: :Type'
                . PHP_EOL . 'Default : :Default'
                . PHP_EOL . 'API access: :AccessSet'
                . PHP_EOL . "Generate file name: :GenerateFileName"
                . PHP_EOL . "Overwrite files with same name: :Overwrite"
                . PHP_EOL . "Length of generated name: :LengthOfGeneratedName"
                . PHP_EOL . "Upload folder: :Folder"
                . PHP_EOL . "Sub Folder Based On Type: :SubFolderBasedOnType"
            ,
            'no_storages' => 'You have no storages',
        ],
    ],
];
