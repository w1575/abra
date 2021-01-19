<?php


namespace frontend\controllers;


use frontend\components\controllers\MainController;

class NotificationController extends MainController
{
    /**
     * @return \yii\web\Response
     */
    public function actionCount()
    {
        return $this->asJson(['count' => mt_rand(100, 1256)]);
    }
}