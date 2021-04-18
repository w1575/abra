<?php


namespace common\components\behaviors\ImageUploaderBehavior\settingCollector;


use common\components\behaviors\ImageUploaderBehavior\SettingsCollecotor;
use Yii;

/**
 * Class GlobalSettingCollector подготавливает массив с настройками, которые получены
 * из \yii::$app->params[]. Они работают все на
 * @package common\components\behaviors\ImageUploaderBehavior\settingCollector
 */
class GlobalSettingCollector extends AbstractSettingsCollector implements SettingsCollectorInterface
{
    private const CONFIG_PARAMS_NAME = "imageUploaderBehavior";
    /**
     * @var array полученный массив с настройками из параметров приложения
     */
    private $receivedSettings;
    /**
     * @inheritDoc
     */
    public function prepareSettings()
    {
        $this->receivedSettings = Yii::$app->params[static::CONFIG_PARAMS_NAME] ?? null;
        // по идеи можно было пройтись циклом по массиву с именами, НО это возможно только
        // в этом случае, поэтому сделаем как и везде
        $this->prepareWebPathSettings();
        $this->prepareFolderPathSettings();
        $this->prepareNamePrefixLengthSettings();
        $this->prepareReplaceDuplicateSettings();
        $this->prepareDeleteOnChangeSettings();
        $this->preparePreviewSettings();

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
     * @return array|mixed
     */
    public function getSettings()
    {
        return $this->preparedSettings;
    }

    public function validateSettings()
    {

    }
    /**
     * @inheritDoc
     */
    public function preparePreviewSettings()
    {
        $this->setSettingsByPropertyName(SettingsCollecotor::PREVIEW_SETTING_NAME);
    }

    /**
     * @param $name
     */
    private function setSettingsByPropertyName($name)
    {
        $this->preparedSettings[$name] = $this->receivedSettings[$name] ?? false;
    }



}