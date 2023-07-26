<?php

namespace App\Storages\YandexDisk;

use App\Data\Storages\Common\DiskSpaceData;
use App\Data\Storages\Common\UploadFileData;
use App\Data\Storages\AccessConfigs\YandexDiskAccessConfigData;
use App\Data\Storages\FileInfo\FileInfoData;
use App\Data\Storages\Settings\StorageSettingsData;
use App\Data\Storages\YandexDisk\FilesListResponseData;
use App\Data\Storages\YandexDisk\UploadFile\UploadUrlResponseData;
use App\Storages\Traits\DecodeResponseBodyTrait;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Utils;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;
use Spatie\LaravelData\DataCollection;

class YandexDiskStorage implements YandexDiskStorageContract
{
    use DecodeResponseBodyTrait;

    protected StorageSettingsData $settingsData;

    protected YandexDiskAccessConfigData $accessConfigData;

    public function __construct(
        protected ClientInterface $client,
    ) {
        $this->settingsData = new StorageSettingsData();
    }

    protected function getAuthorizationHeader(): array
    {
        return [
            'Authorization' => 'OAuth ' . $this->accessConfigData->debugToken,
        ];
    }

    /**
     * @throws GuzzleException
     */
    protected function sendRequest(string $method, array $queryParams = [], string $uri = ''): ResponseInterface
    {
        return $this->client->request(
            $method,
            $uri,
            [
                'headers' => $this->getAuthorizationHeader(),
                'query' => $queryParams,
            ]
        );
    }

    /**
     * @param  YandexDiskAccessConfigData $config
     * @return static
     */
    public function setAccessConfig(mixed $config): static
    {
        $this->accessConfigData = $config;
        return $this;
    }

    /**
     * @inheritDoc
     * @throws GuzzleException
     */
    public function getFilesList(string $folder): DataCollection
    {
        $response = $this->sendRequest(
            'GET',
            [
                'path' => $folder,
                'limit' => 10
            ]
        );

        $resultArray = json_decode((string)($response->getBody()), true);
        // TODO: make this
        return FilesListResponseData::collection($resultArray);
    }

    /**
     * @inheritDoc
     */
    public function getFileInfo(string $filePathOnCloud): FileInfoData
    {
        return FileInfoData::from([]); // TODO: make this
    }

    /**
     * @inheritDoc
     * @throws GuzzleException
     */
    public function uploadFile(UploadFileData $uploadFileData): ?FileInfoData
    {
        $settings = $this->settingsData;
        $localPath = $uploadFileData->localFilePath;
        $fileName = $settings->generateFileName
            ? Str::random($settings->lengthOfGeneratedName) . pathinfo($localPath, PATHINFO_EXTENSION)
            : basename($localPath)
        ;

        if (!str_ends_with($this->settingsData->folder, '/')) {
            $this->settingsData->folder .= "/";
        }

        $uploadFileData->remoteFullPath = $this->settingsData->folder . $fileName;

        $uploadUrlData = $this->getUploadLink($uploadFileData);

        if ($uploadUrlData === null) {
            // todo: maybe throw exception
            return null;
        }

        $params = [
            'body' => Utils::tryFopen($uploadFileData->localFilePath, 'r'),
        ]; // RIP SOLID completely :(

        $response = $this->client->request(
            $uploadUrlData->method,
            $uploadUrlData->href,
            $params
        );

        if ($response->getStatusCode() === 201) {
            $fileInfoData = new FileInfoData($fileName);
            $fileInfoData->fullPath = $uploadFileData->remoteFullPath;

            return $fileInfoData;
        }

        return new FileInfoData();
    }

    protected function getUploadLink(UploadFileData $uploadFileData): ?UploadUrlResponseData
    {
        $params = [
            'path' => $uploadFileData->remoteFullPath,
            'overwrite' => $this->settingsData->overwrite,
        ];
        try {
            $result = $this->sendRequest('GET', $params, 'resources/upload');
            return UploadUrlResponseData::from(
                $this->decodeResponseBody($result)
            );
        } catch (GuzzleException $e) {
            dump($e->getMessage());
            return null;
        }
    }

    public function createFolder(string $folderPath): bool
    {
        return false; // TODO: make this
    }

    public function isFileExist(FileInfoData $fileData): bool
    {
        return false; // TODO: make this
    }

    public function setStorageSettings(StorageSettingsData $settings): static
    {
        $this->settingsData = $settings;
        return $this;
    }

    public function getDiskSpace(): DiskSpaceData
    {
        return new DiskSpaceData(); // TODO: make this
    }

    public function getStorageSettings(): StorageSettingsData
    {
        return new StorageSettingsData();
    }
}
