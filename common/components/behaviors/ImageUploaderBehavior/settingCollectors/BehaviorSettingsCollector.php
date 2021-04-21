<?php


namespace common\components\behaviors\ImageUploaderBehavior\settingCollectors;


use common\components\behaviors\ImageUploaderBehavior\SettingsCollecotor;
use Yii;

/**
 * Class GlobalSettingCollector подготавливает массив с настройками, которые получены
 * из \yii::$app->params[]. Они работают все на
 * @package common\components\behaviors\ImageUploaderBehavior\settingCollector
 */
class BehaviorSettingsCollector extends AbstractSettingsCollector implements SettingsCollectorInterface
{
    /**
     * @inheritDoc
     */
    public function prepareSettings()
    {
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
     * @param $name
     * @param $settings
     */
    public function setSettingsByPropertyName($name)
    {
        $settings = $this->uploader->{$name};
        if (isset($settings)) {
            $this->preparedSettings[$name] = $settings;
        }
    }



}