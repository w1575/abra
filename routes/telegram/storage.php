<?php

/** @var SergiX44\Nutgram\Nutgram $bot */

use App\Telegram\Conversations\AddCloudStorageConversation;
use App\Telegram\Conversations\DeleteStorageConversation;
use App\Telegram\Conversations\SetDefaultStorageConversation;
use App\Telegram\Middleware\CheckUserStatusMiddleware;
use App\Telegram\Middleware\SetLanguageMiddleware;
use SergiX44\Nutgram\Nutgram;

$bot->group(function (Nutgram $bot) {
    $bot
        ->onCommand('add_storage', AddCloudStorageConversation::class)
        ->description('Добавить хранилище')
    ;

    $bot
        ->onCommand('delete_storage', DeleteStorageConversation::class)
        ->description('Удалить хранилище. Delete storage.')
    ;

    $bot->onCommand('set_default_storage', SetDefaultStorageConversation::class)
        ->description('Хранилище по-умолчанию')
    ;
})->middleware(CheckUserStatusMiddleware::class)->middleware(SetLanguageMiddleware::class);