<?php


namespace common\components\behaviors\ImageUploaderBehavior\factories;


use common\components\behaviors\ImageUploaderBehavior\settingBuilders\SettingsBuilder;

class SettingsBuilderFactory
{
    /**
     * @param $majorSettings
     * @param $minorSettings
     * @return SettingsBuilder
     */
    public static function build($majorSettings, $minorSettings, $uploader)
    {
        $model = new SettingsBuilder();
        $model->majorSettings = $majorSettings;
        $model->minorSettings = $minorSettings;
        $model->uploader = $uploader;
        $model->buildSettings();;

        return $model;
    }
}