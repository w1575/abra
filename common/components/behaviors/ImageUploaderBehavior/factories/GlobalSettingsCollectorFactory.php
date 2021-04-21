<?php


namespace common\components\behaviors\ImageUploaderBehavior\factories;


use common\components\behaviors\ImageUploaderBehavior\settingCollectors\GlobalSettingsCollector;

class GlobalSettingsCollectorFactory
{
    /**
     * @return GlobalSettingsCollector
     */
    public static function build()
    {
        $model = new GlobalSettingsCollector();
        $model->prepareSettings();
        return $model;
    }
}