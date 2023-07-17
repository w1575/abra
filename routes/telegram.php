<?php

/** @var SergiX44\Nutgram\Nutgram $bot */

use App\Telegram\Commands\DeleteCloudCommand;
use App\Telegram\Commands\StorageListCommand;
use App\Telegram\Commands\TestCommand;
use App\Telegram\Conversations\AddCloudStorageConversation;
use App\Telegram\Conversations\DeleteStorageConversation;
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

$bot->onCommand('start', StartConversation::class)->description('Init new user');

$bot->group(function(Nutgram $bot) {
    $bot->registerCommand(TestCommand::class);

    $bot
        ->onCommand('add_storage', AddCloudStorageConversation::class)
        ->description('Add new cloud storage')
    ;

    $bot
        ->onCommand('delete_storage', DeleteStorageConversation::class)
        ->description('Удалить хранилище. Delte storage.')
    ;

    $bot->registerCommand(StorageListCommand::class);

})->middleware(CheckUserStatusMiddleware::class);


require __DIR__ . '/telegram/files-handlers.php';
