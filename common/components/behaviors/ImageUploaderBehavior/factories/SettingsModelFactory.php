<?php


namespace common\components\behaviors\ImageUploaderBehavior\factories;


use common\components\behaviors\ImageUploaderBehavior\models\SettingsModel;
use yii\db\Exception;

final class SettingsModelFactory
{
    /**
     * @param $params
     * @return SettingsModel
     * @throws Exception
     */
    public static function build($params, $scenario = SettingsModel::SCENARIO_DEFAULT)
    {
        $model = new SettingsModel();
        $model->scenario = $scenario;
        $model->load($params);
        $model->validate();
        return $model;
    }
}