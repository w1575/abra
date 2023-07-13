<?php

namespace App\Jobs\Bot;

use App\Data\Telegram\FileHandlerDispatchData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use SergiX44\Nutgram\Nutgram;

class UploadFileToStorage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(FileHandlerDispatchData $data)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(Nutgram $bot): void
    {
        //
    }
}
