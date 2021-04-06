<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'abra-frontend',
    'name' => 'Abra. Реестр сайтов',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru-RU',
    'sourceLanguage' => 'ru-US',
    'controllerNamespace' => 'frontend\controllers',
    'layout' => '@common/themes/AdminLTE3/views/layouts/content',
    'components' => [
        'view' => [
            'theme' => [
                'basePath' => '@common/themes/AdminLTE3',
//                'baseUrl' => '@web/themes/bootstrap4material',
//                'pathMap' => [
//                    '@app/views' => '@app/themes/basic',
//                ],
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [

            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'portal' => 'portal/portal/index',
                'portal/<action:[\w\+]>' => 'portal/portal/<action:[\w\+]>',
            ],
        ],

    ],
    'params' => $params,
];
