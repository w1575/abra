<?php


namespace common\components\behaviors\ImageUploaderBehavior\settingCollectors;


use common\components\behaviors\ImageUploaderBehavior\ImageUploaderBehavior;
use common\components\behaviors\ImageUploaderBehavior\SettingsCollecotor;


abstract class AbstractSettingsCollector implements SettingsCollectorInterface
{

    /**
     * @var ImageUploaderBehavior
     */
    public $uploader;
    /**
     * @var array подготовленные настройки
     */
    protected $preparedSettings = [];

    /**
     * @inheritDoc
     * @return array|mixed
     */
    public function getSettings()
    {
        return $this->preparedSettings;
    }

    /**
     * @inheritDoc
     */
    public function prepareWebPathSettings()
    {
        $this->setSettingsByPropertyName(SettingsCollecotor::WEB_PATH_SETTING_NAME);
    }

    /**
     * @inheritDoc
     */
    public function prepareFolderPathSettings()
    {
        $this->setSettingsByPropertyName(SettingsCollecotor::FOLDER_PATH_SETTING_NAME);
    }

    /**
     * @inheritDoc
     */
    public function prepareNamePrefixLengthSettings()
    {
        $this->setSettingsByPropertyName(SettingsCollecotor::NAME_PREFIX_SETTING_NAME);
    }

    /**
     * @inheritDoc
     */
    public function prepareDeleteOnChangeSettings()
    {
        $this->setSettingsByPropertyName(SettingsCollecotor::DELETE_ON_CHANGE_SETTING_NAME);
    }

    /**
     * @inheritDoc
     */
    public function prepareReplaceDuplicateSettings()
    {
        $this->setSettingsByPropertyName(SettingsCollecotor::REPLACE_DUPLICATE_SETTING_NAME);
    }

    /**
     * @inheritDoc
     */
    public function preparePreviewSettings()
    {
        $this->setSettingsByPropertyName(SettingsCollecotor::PREVIEW_SETTING_NAME);
    }


}