<?php

/** @var SergiX44\Nutgram\Nutgram $bot */

use App\Telegram\Commands\DeleteCloudCommand;
use App\Telegram\Commands\StorageListCommand;
use App\Telegram\Commands\TestCommand;
use App\Telegram\Conversations\AddCloudStorageConversation;
use App\Telegram\Conversations\DeleteStorageConversation;
use App\Telegram\Conversations\SetLanguageConversation;
use App\Telegram\Conversations\SetTokenConversation;
use App\Telegram\Conversations\StartConversation;
use App\Telegram\Middleware\CheckUserStatusMiddleware;
use SergiX44\Nutgram\Nutgram;

/*
|--------------------------------------------------------------------------
| Nutgram Handlers
|--------------------------------------------------------------------------
|
| Here is where you can register telegram handlers for Nutgram. These
| handlers are loaded by the NutgramServiceProvider. Enjoy!
|
*/

require __DIR__ . "/telegram/common.php";

$bot->group(function (Nutgram $bot) {
    $bot
        ->onCommand('add_storage', AddCloudStorageConversation::class)
        ->description('Add new cloud storage')
    ;

    $bot
        ->onCommand('delete_storage', DeleteStorageConversation::class)
        ->description('Удалить хранилище. Delete storage.')
    ;

})->middleware(CheckUserStatusMiddleware::class);


require __DIR__ . '/telegram/files-handlers.php';
