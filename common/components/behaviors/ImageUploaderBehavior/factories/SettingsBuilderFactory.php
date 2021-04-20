<?php


namespace common\components\behaviors\ImageUploaderBehavior\factories;


use common\components\behaviors\ImageUploaderBehavior\settingBuilders\SettingsBuilder;

class SettingsBuilderFactory
{
    /**
     * @param $majorSettings array|null
     * @param $minorSettings array|null
     * @return SettingsBuilder
     */
    public static function build($majorSettings, $minorSettings)
    {
        $model = new SettingsBuilder();
        $model->majorSettings = $majorSettings;
        $model->minorSettings = $minorSettings;

        return $model;
    }
}