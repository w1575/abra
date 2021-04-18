<?php

namespace common\components\behaviors\ImageUploaderBehavior\settingCollector;

use \Exception;

interface SettingsCollectorInterface
{
    /**
     * Валидация полученных настроек
     */
//    public function validateSettings();

    /**
     * Установка настроек в параметры главного коллектора настроек
     * @return mixed
     */
    public function getSettings();

    /**
     * @return mixed
     */
    public function prepareSettings();

    /**
     * Подготавливает настройки web пути к изображению
     */
    public function prepareWebPathSettings();

    /**
     * Подготавливает настройки пути к папке на стороне сервера
     */
    public function prepareFolderPathSettings();

    /**
     * Подготавливает настройки префикса для загруженного файла
     */
    public function prepareNamePrefixLengthSettings();

    /**
     * Подготавливает настройку замены дубликата по имени
     */
    public function prepareReplaceDuplicateSettings();

    /**
     * Подготавливает настройку для удаления старого файла, при загрузки нового
     */
    public function prepareDeleteOnChangeSettings();

    /**
     * Подготавливает настройки для генерируемых превьюшек изображений
     */
    public function preparePreviewSettings();
}