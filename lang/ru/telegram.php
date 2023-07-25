<?php

return [
    'start_command' => [
        'need_set_the_token' => 'Необходимо установить токен.',
        'try_again' => 'Повторите попытку.',
        'token_in_use' => 'Токен уже используется другим пользователем.',
        'token_set' => 'Токен успешно установлен. Теперь вы можете использовать бот!',
    ],
    'language_been_set' => 'Язык был установлен',
    'on_message' => [
        'start_processing' => 'Начинаю обработку данных.', // I'm starting data processing.
    ],
    'storage' => [
        'set_default' => 'Установить по-умолчанию',
        'back_to_list' => 'Назад к списку хранилищ',
        'view' => [
            'list' => 'Список Ваших хранилищ',
            'pick' => 'Выберите хранилище',
            'info' => 'Информация о хранилище: '
                . PHP_EOL . 'Название: :Name'
                . PHP_EOL . 'Тип: :Type'
                . PHP_EOL . 'По-умолчанию: :Default'
                . PHP_EOL . 'Доступы к API: :AccessSet'
                . PHP_EOL . "Генерировать имя файлы: :GenerateFileName"
                . PHP_EOL . "Перезаписывать файлы с одинаковыми именами: :Overwrite"
//                . PHP_EOL . "Длина генерируемого имени: :LengthOfGeneratedName"
                . PHP_EOL . "Директория для загрузки: :Folder"
                . PHP_EOL . "Поддериктория с именем типа файла: :SubFolderBasedOnType"
            ,
            'no_storages' => 'У Вас нет хранилищ',
        ],
    ],
];
