<?php


namespace common\components\behaviors\ImageUploaderBehavior;


use yii\base\BaseObject;

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