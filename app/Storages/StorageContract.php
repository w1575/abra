<?php

namespace App\Storages;

use App\Data\Storages\FileInfo\FileInfoData;
use App\Data\Storages\YandexDisk\FilesListResponseData;
use Spatie\LaravelData\Contracts\DataObject;

interface StorageContract
{
    /**
     * @param  DataObject  $config
     * @return mixed
     */
    public function setConfig(DataObject $config): static;

    /**
     * Getting a list of files in the cloud
     * @param  string  $folder
     * @return FilesListResponseData
     */
    public function getFilesList(string $folder): FilesListResponseData;

    /**
     * Getting info about file in cloud
     * @param  string  $filePathOnCloud
     * @return FileInfoData
     */
    public function getFileInfo(string $filePathOnCloud): FileInfoData;

    /**
     * @param  string  $fileLocalPath
     * @return mixed
     */
    public function uploadFile(string $fileLocalPath): FileInfoData;

    public function createFolder(string $folderPath): bool;

    public function isFileExist(FileInfoData $fileData): bool;
}
