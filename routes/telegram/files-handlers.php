<?php

use App\Telegram\Handlers;
use App\Telegram\Middleware\CheckUserStatusMiddleware;

/** @var SergiX44\Nutgram\Nutgram $bot */

$bot->group(function (\SergiX44\Nutgram\Nutgram $bot) {
    $bot->onMessage(Handlers\OnMessageHandler::class);

    $bot->onPhoto(Handlers\PhotoHandler::class);

    $bot->onVideo(Handlers\VideoHandler::class);

    $bot->onAudio(Handlers\AudioHandler::class);

    $bot->onAnimation(Handlers\AnimationHandler::class);

    $bot->onVoice(Handlers\VoiceHandler::class);

    $bot->onSticker(Handlers\StickerHandler::class);

    $bot->onVideoNote(Handlers\VideoNoteHandler::class);
})->middleware(CheckUserStatusMiddleware::class);
