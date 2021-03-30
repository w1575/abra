<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'plugins/select2/css/select2.css',
        'plugins/select2/css/select2-bootstrap4.css',
        'css/main.css',
    ];
    public $js = [
        'plugins/select2/js/select2.full.js',
        'plugins/select2/js/i18n/ru.js',
        'plugins/select2/select2-init.js',
        'js/main.js',
    ];
    public $depends = [
        Bootstrap4Asset::class,
    ];
}
