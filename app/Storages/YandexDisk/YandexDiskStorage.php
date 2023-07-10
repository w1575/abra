<?php

namespace App\Storages\YandexDisk;

use App\Data\Storages\Common\DiskSpaceData;
use App\Data\Storages\Config\YandexDiskConfigData;
use App\Data\Storages\FileInfo\FileInfoData;
use App\Data\Storages\Settings\StorageSettingsData;
use App\Data\Storages\YandexDisk\FilesListResponseData;
use App\Storages\StorageContract;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Spatie\LaravelData\Contracts\DataObject;
use Spatie\LaravelData\DataCollection;

class YandexDiskStorage implements YandexDiskStorageContract
{
    protected StorageSettingsData $settingsData;



    public function __construct(
        protected ClientInterface $client
    )
    {
        d
    }

    protected function getAuthorizationHeader(): array
    {
        return [
            'Authorization' => 'OAuth ' . env('YANDEX_DISK_OAUTH_TOKEN'), // TODO: temporary solution
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
     * @inheritDoc
     * @param YandexDiskConfigData $config
     */
    public function setConfig(mixed $config): static
    {
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
                'path' => $folder, 'limit' => 10
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
        $data = FileInfoData::from([]);

        return $data; // TODO: make this
    }

    /**
     * @inheritDoc
     */
    public function uploadFile(string $fileLocalPath): FileInfoData
    {
        $data = FileInfoData::from([]);

        return $data; // TODO: make this
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
        // TODO: Implement getStorageSettings() method.
    }
}
