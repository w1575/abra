<?php


namespace frontend\assets;


class Bootstrap4Asset extends \yii\bootstrap4\BootstrapAsset
{
    public $js = [
        'js/bootstrap.min.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}