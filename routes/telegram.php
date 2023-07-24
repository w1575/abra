<?php

/** @var SergiX44\Nutgram\Nutgram $bot */

use App\Telegram\Conversations\AddCloudStorageConversation;
use App\Telegram\Conversations\DeleteStorageConversation;
use App\Telegram\Conversations\SetDefaultStorageConversation;
use App\Telegram\Middleware\CheckUserStatusMiddleware;
use App\Telegram\Middleware\SetLanguageMiddleware;
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

$bot->middleware(SetLanguageMiddleware::class);
$bot->middleware(CheckUserStatusMiddleware::class);

require __DIR__ . "/telegram/common.php";

require __DIR__ . '/telegram/storage.php';

require __DIR__ . '/telegram/files-handlers.php';
