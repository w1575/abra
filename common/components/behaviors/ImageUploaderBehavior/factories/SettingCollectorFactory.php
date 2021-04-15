<?php


namespace common\components\behaviors\ImageUploaderBehavior\factories;


use common\components\behaviors\ImageUploaderBehavior\SettingsCollecotor;


final class SettingCollectorFactory
{
    /**
     * @param $type
     */
    public static function build($uploader)
    {
        $collector = new SettingsCollecotor();
        $collector->setUploader($uploader);
        return $collector;
    }
}