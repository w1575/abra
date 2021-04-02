<?php


namespace common\themes\AdminLTE3\assets;


use backend\assets\AppAsset;
use yii\web\YiiAsset;

class ALTE3MinAsset extends \yii\web\AssetBundle
{

    //public $baseUrl = '@web';
    public $sourcePath = '@common/themes/AdminLTE3/web-files/';
    public $css = [
        'plugins/fontawesome-free/css/all.min.css',
        'plugins/icheck-bootstrap/icheck-bootstrap.min.css',
        'dist/css/adminlte.min.css',
    ];
    public $js = [
        'js/adminlte.js',
    ];
    public $depends = [
        YiiAsset::class,

    ];
}