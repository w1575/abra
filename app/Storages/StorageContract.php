<?php

namespace App\Storages;

use App\Data\Storages\Common\DiskSpaceData;
use App\Data\Storages\Common\UploadFileData;
use App\Data\Storages\FileInfo\FileInfoData;
use App\Data\Storages\Settings\StorageSettingsData;
use App\Data\Storages\YandexDisk\FilesListResponseData;
use Spatie\LaravelData\Contracts\DataObject;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

interface StorageContract
{
    public function setConfig(mixed $config): static;

    public function setStorageSettings(StorageSettingsData $settings): static;

    /**
     * Getting a list of files in the cloud
     * @param  string  $folder
     * @return DataCollection
     */
    public function getFilesList(string $folder): DataCollection;

    /**
     * Getting info about file in cloud
     * @param  string  $filePathOnCloud
     * @return FileInfoData
     */
    public function getFileInfo(string $filePathOnCloud): FileInfoData;

    /**
     * @param  UploadFileData  $uploadFileData
     * @return FileInfoData|null
     */
    public function uploadFile(UploadFileData $uploadFileData): ?FileInfoData;

    public function createFolder(string $folderPath): bool;

    public function isFileExist(FileInfoData $fileData): bool;

    public function getDiskSpace(): DiskSpaceData;

    public function getStorageSettings(): StorageSettingsData;
}
