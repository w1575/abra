<?php

namespace App\Console\Commands\Test;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use SergiX44\Nutgram\Nutgram;

class DownloadDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:download-data-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(Nutgram $bot)
    {
        $file = $bot
            ->getFile('BAACAgIAAxkBAAOxZK3R57RjOVsnEXHJhPU-NXxIheoAAjk4AAK3pWlJSdSiEEcTVrcvBA')
            ->save(storage_path('app/public/test/'))
        ;

//        $filePath = storage_path('app/public/test' . $file->file_path);
//        $bot->getFile($fileId)->save('file/or/directory');
//        try {
//            $bot->downloadFile($file, $filePath);
//        } catch (GuzzleException|NotFoundExceptionInterface|ContainerExceptionInterface|\Throwable $e) {
//        }

//        dd(mime_content_type($filePath));
    }
}
