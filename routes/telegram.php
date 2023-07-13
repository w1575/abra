<?php

/** @var SergiX44\Nutgram\Nutgram $bot */

use App\Telegram\Commands\TestCommand;
use App\Telegram\Conversations\StartConversation;
use App\Telegram\Middleware\CheckUserStatusMiddleware;

/*
|--------------------------------------------------------------------------
| Nutgram Handlers
|--------------------------------------------------------------------------
|
| Here is where you can register telegram handlers for Nutgram. These
| handlers are loaded by the NutgramServiceProvider. Enjoy!
|
*/

$bot->onCommand('start', StartConversation::class)->description('Who r u?');

$bot->registerCommand(TestCommand::class)->middleware(CheckUserStatusMiddleware::class);

require __DIR__ . '/telegram/files-handlers.php';
