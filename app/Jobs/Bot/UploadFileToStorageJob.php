<?php

namespace App\Jobs\Bot;

use App\Components\MimeType\GetFileExtensionByMimeMimeType;
use App\Data\Storages\Common\UploadFileData;
use App\Data\Telegram\FileHandlerDispatchData;
use App\Models\CloudStorage;
use App\Storages\Factory\StorageFactoryContract;
use App\Storages\StorageContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use SergiX44\Nutgram\Nutgram;

class UploadFileToStorageJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected StorageContract $storageComponent;

    protected FileHandlerDispatchData $fileHandlerDispatchData;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $data)
    {
    }

    /**
     * Execute the job.
     * @throws BindingResolutionException
     */
    public function handle(Nutgram $bot): void
    {
        $this->fileHandlerDispatchData = FileHandlerDispatchData::from($this->data);

        $cloudStorage = CloudStorage::whereTelegramId($this->fileHandlerDispatchData->telegramUserId)
            ->whereId($this->fileHandlerDispatchData->cloudStorageId)
            ->first()
        ;

        $this->storageComponent = app(StorageFactoryContract::class)->make($cloudStorage);

        $tempPath = $this->getFileTempPath();

        $bot->getFile($this->fileHandlerDispatchData->fileId)->save($tempPath);
        $getExtension = app(GetFileExtensionByMimeMimeType::class);
        $extension = $getExtension($tempPath);
        $newName = "$tempPath.$extension";

        rename($tempPath, $newName);
        $this->uploadFile($newName);
        unlink($newName);
        $bot->getFile($this->fileHandlerDispatchData->fileId);
    }

    protected function getFileTempPath(): string
    {
        $tempPath = storage_path("app/temp-files/{$this->fileHandlerDispatchData->telegramUserId}/");
        if (!is_dir($tempPath)) {
            mkdir($tempPath, 0755, true);
        }

        return $tempPath . Str::random(32);
    }

    protected function removeDir(): bool
    {
        return rmdir($this->getFileTempPath());
    }

    protected function removeTempFile(string $name): void
    {
        unlink($name);
    }

    protected function uploadFile(string $newName): bool
    {
        $data = new UploadFileData($newName);
        $uploadData = $this->storageComponent->uploadFile($data);

        return $uploadData !== null;
    }
}
