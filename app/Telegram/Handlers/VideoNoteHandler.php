<?php

namespace App\Telegram\Handlers;

use App\Telegram\Handlers\traits\FileHandlerTrait;
use SergiX44\Nutgram\Nutgram;

class VideoNoteHandler
{
    use FileHandlerTrait;

    public function __invoke(Nutgram $bot): void
    {
        $fileId = $bot->message()->video_note->file_id;
        $this->dispatchJob($bot, $fileId);
    }
}
