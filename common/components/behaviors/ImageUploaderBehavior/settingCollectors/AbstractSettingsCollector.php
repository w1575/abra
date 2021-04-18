<?php


namespace common\components\behaviors\ImageUploaderBehavior\settingCollector;


use common\components\behaviors\ImageUploaderBehavior\ImageUploaderBehavior;


abstract class AbstractSettingsCollector implements SettingsCollectorInterface
{

    /**
     * @var ImageUploaderBehavior
     */
    public $uploader;
    /**
     * @var array подготовленные настройки
     */
    public $preparedSettings;








}