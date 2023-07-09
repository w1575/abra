<?php

namespace App\Storages\YandexDisk;

use App\Data\Storages\FileInfo\FileInfoData;
use App\Data\Storages\YandexDisk\FilesListResponseData;
use App\Storages\StorageContract;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Spatie\LaravelData\Contracts\DataObject;

class YandexDiskStorage implements StorageContract
{

    public function __construct(
        protected ClientInterface $client
    )
    {
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
     */
    public function setConfig(DataObject $config): static
    {
        return $this;
    }

    /**
     * @inheritDoc
     * @throws GuzzleException
     */
    public function getFilesList(string $folder): FilesListResponseData
    {
        $response = $this->sendRequest(
            'GET',
            [
                'path' => $folder, 'limit' => 10
            ]
        );

        $resultArray = json_decode((string)($response->getBody()), true);

        return FilesListResponseData::from($resultArray);
    }

    /**
     * @inheritDoc
     */
    public function getFileInfo(string $filePathOnCloud): FileInfoData
    {
        $data = FileInfoData::from([]);

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function uploadFile(string $fileLocalPath): FileInfoData
    {


        $data = FileInfoData::from([]);

        return $data;
    }

    public function createFolder(string $folderPath): bool
    {
        return false;
    }

    public function isFileExist(FileInfoData $fileData): bool
    {

    }
}
