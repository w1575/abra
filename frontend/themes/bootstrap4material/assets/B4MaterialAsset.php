<?php

namespace frontend\themes\bootstrap4material\assets;

class B4MaterialAsset extends \yii\web\AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@frontend/themes/bootstrap4material/web';
    /**
     * @var array
     */
    public $js = [
        'vendor/jquery.cookie/jquery.cookie.js',
        'vendor/popper.js/umd/popper.min.js',
        'vendor/chart.js/Chart.min.js',
        'js/charts-custom.js',
        'js/front.js'
    ];

    public $css = [
//        'vendor/font-awesome/css/font-awesome.min.css',
        'css/fontastic.css',
        'css/style.default.css',
        'css/custom.css',
        'vendor/font-awesome/css/font-awesome.min.css',
    ];
    /**
     * @var string[]
     */
    public $depends = [
        'yii\web\YiiAsset',
        'frontend\assets\Bootstrap4Asset',
    ];
}