<?php


namespace common\components\behaviors\ImageUploaderBehavior\factories;


use common\components\behaviors\ImageUploaderBehavior\settingCollectors\BehaviorSettingsCollector;


class BehaviorSettingsCollectorFactory
{
    /**
     * @param $uploader
     * @return BehaviorSettingsCollector
     */
    public static function build($uploader)
    {
        $model = new BehaviorSettingsCollector();
        $model->uploader = $uploader;
        $model->prepareSettings();
        return $model;
    }
}