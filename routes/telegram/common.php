<?php

use App\Models\TelegramAccountSettings;
use App\Telegram\Commands\TestCommand;
use App\Telegram\Conversations\SetLanguageConversation;
use App\Telegram\Conversations\SetTokenConversation;
use App\Telegram\Conversations\StartConversation;
use App\Telegram\Middleware\CheckUserStatusMiddleware;
use App\Telegram\Middleware\SetLanguageMiddleware;
use SergiX44\Nutgram\Nutgram;

/** @var SergiX44\Nutgram\Nutgram $bot */

$bot->group(function (Nutgram $bot) {
    $bot->registerCommand(TestCommand::class);

    $bot
        ->onCommand('start', StartConversation::class)
        ->description('Init new user')
        ->skipGlobalMiddlewares()
    ;

    $bot
        ->onCommand('set_language', SetLanguageConversation::class)
        ->description('Установка языка бота. Setting the language of the bot.')
        ->skipGlobalMiddlewares()
    ;

    $bot
        ->onCommand('set_token', SetTokenConversation::class)
        ->description('Установка кода приглашения. Setting the invitation code.')
        ->skipGlobalMiddlewares()
    ;

});
