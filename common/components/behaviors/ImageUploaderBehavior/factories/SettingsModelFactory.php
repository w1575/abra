<?php


namespace common\components\behaviors\ImageUploaderBehavior\factories;


use common\components\behaviors\ImageUploaderBehavior\model\SettingsModel;
use yii\db\Exception;

final class SettingsModelFactory
{
    /**
     * @param $params
     * @return SettingsModel
     * @throws Exception
     */
    public static function build($params)
    {
        $model = new SettingsModel();

        return $model;
    }
}