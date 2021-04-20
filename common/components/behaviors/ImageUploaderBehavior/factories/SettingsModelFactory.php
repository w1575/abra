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
        $model = new SettingsModel($params);
        if ($model->validate() === false) {
            throw new Exception('При валидации глобальных настроек произошла ошибка', $model->errors);
        }

        return $model;
    }
}