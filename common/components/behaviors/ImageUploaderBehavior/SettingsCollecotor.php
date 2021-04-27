<?php


namespace common\components\behaviors\ImageUploaderBehavior;

use common\components\behaviors\ImageUploaderBehavior\factories\BehaviorSettingsCollectorFactory;
use common\components\behaviors\ImageUploaderBehavior\factories\GlobalSettingsCollectorFactory;
use common\components\behaviors\ImageUploaderBehavior\factories\SettingsBuilderFactory;
use common\components\behaviors\ImageUploaderBehavior\factories\SettingsModelFactory;
use common\components\behaviors\ImageUploaderBehavior\models\SettingsModel;
use Yii;
use yii\db\Exception;

/**
 * Class SettingsCollecotor если честно я не знаю что и зачем я делаю :D
 * Но интересно попробовать. Этот класс будет отвечать
 * TODO: очень ужасные способы установки и получения параметров, и, кажется, переборщил с числом циклов
 * @package common\components\behaviors\ImageUploaderBehavior
 */
class SettingsCollecotor extends \yii\base\Component
{
    public const PREVIEW_SETTING_NAME = 'previewSettings';
    public const WEB_PATH_SETTING_NAME = 'webPath';
    public const FOLDER_PATH_SETTING_NAME = 'folderPath';
    public const NAME_PREFIX_SETTING_NAME = 'namePrefixLength';
    public const REPLACE_DUPLICATE_SETTING_NAME = 'replaceDuplicate';
    public const DELETE_ON_CHANGE_SETTING_NAME = 'deleteOnChange';
    public const DB_ATTRIBUTE_NAME = 'dbAttribute';

    public const PREVIEW_SETTING_WIDTH_NAME = 'width';
    public const PREVIEW_SETTING_HEIGHT_NAME = 'height';
    public const PREVIEW_SETTING_QUALITY_NAME = 'quality';
    public const PREVIEW_SETTING_PREFIX_LENGTH_NAME = 'prefixLength';
    public const PREVIEW_SETTING_FOLDER_NAME = 'folder';
//    width
//    height
//    quality
//    prefixLength
//    folder

    /**
     * @var ImageUploaderBehavior
     */
    private $uploader;
    /**
     * @var array массив с настройками из параметров приложения
     */
    private $globalSettings;
    /**
     * @var array настройки, которые указаны в параметрах поведения
     */
    private $behaviorSettings;
    /**
     * @var array подготовленные праметры для поведения на основе настроек поведений и настроек в конфиге приложения
     */
    private $commonSettings;
    /**
     * @var array параметры, которые указаны в настройках атрибутов
     */
    private $attributeSettings= [];
    /**
     * Список параметров
     * @var string[]
     */
    public $settingNames = [
        //'webPath',
        //'folderPath',
        //'namePrefixLength',
        //'replaceDuplicate',
        //'deleteOnChange',
        //'previewSettings',
    ];
    /**
     * @var string[]
     */
    public $previewSettingNames = [
//        'width',
//        'height',
//        'quality',
//        'prefixLength',
//        'folder',
    ];
    /**
     * @var array подготовленные настройки для каждого атрибута файлов
     */
    public $preparedSettings;
    /**
     * @var array названия атрибутов с файлами
     */
    private $fileAttributeNames = [];
    /**
     * @param $uploader
     */
    public function setUploader($uploader)
    {
        $this->uploader = $uploader;
    }

    /**
     * Небольшая инициализация
     */
    public function init()
    {
        $this->settingNames = [
            static::PREVIEW_SETTING_NAME,
            static::WEB_PATH_SETTING_NAME,
            static::FOLDER_PATH_SETTING_NAME,
            static::NAME_PREFIX_SETTING_NAME,
            static::REPLACE_DUPLICATE_SETTING_NAME,
            static::DELETE_ON_CHANGE_SETTING_NAME,
        ];

        $this->previewSettingNames = [
            static::PREVIEW_SETTING_WIDTH_NAME,
            static::PREVIEW_SETTING_HEIGHT_NAME,
            static::PREVIEW_SETTING_QUALITY_NAME,
            static::PREVIEW_SETTING_PREFIX_LENGTH_NAME,
            static::PREVIEW_SETTING_FOLDER_NAME,
        ];
    }

    /**
     * Собирает глобальные настройки и настройки поведения конкретной модели
     */
    public function prepareCommonSettings()
    {
        $globalSettingsCollector = GlobalSettingsCollectorFactory::build();
        $this->globalSettings = $globalSettingsCollector->getSettings();
        unset($globalSettingsCollector);

        $behaviorSettingsCollector = BehaviorSettingsCollectorFactory::build($this->uploader);
        $this->behaviorSettings = $behaviorSettingsCollector->getSettings();
        unset($behaviorSettingsCollector);

        // TODO теперь нужно сделать сборку этих настроек
    }

    /**
     * @throws \Exception
     */
    public function validateCommonSettings()
    {
        $this->validateSettings($this->globalSettings);
        $this->validateSettings($this->behaviorSettings);
    }

    /**
     * @param $parmas
     * @throws \Exception
     */
    protected function validateSettings($parmas)
    {
        $model = new SettingsModel;
        $model->load($parmas);
        if ($model->hasErrors() === true) {
            $errorsInline = implode(PHP_EOL, $model->errors);
            throw new \Exception("При проверке настроек произошла ошибка: {$errorsInline}" );
        }
    }

    /**
     * Подготавливает общие настройки для конкретной модели
     */
    public function buildCommonSettings()
    {
        $builder = SettingsBuilderFactory::build($this->behaviorSettings, $this->globalSettings, $this);
        $this->commonSettings = $builder->getSettings();
        unset($builder);
    }

    /**
     * @throws \Exception
     */
    public function prepareAttributeSettings()
    {
        if (!is_array($this->uploader->attributeParams)) {
            throw new \Exception('Параметр имеет неверный формат');
        }

        foreach ($this->uploader->attributeParams as $fileAttribute => $attributeParam) {
            $paramsModel = SettingsModelFactory::build($attributeParam, SettingsModel::SCENARIO_FILE_ATTRIBUTE_VALIDATE);
            if ($paramsModel->validate() === false) {
                $inlineErrors = implode(PHP_EOL, $paramsModel->errors);
                throw new \Exception("В параметрах атрибута {$fileAttribute} есть ошибки: {$inlineErrors}");
            }

            $this->attributeSettings[$fileAttribute] = $paramsModel->attributes;
        }
    }

    /**
     * Подготавливает настройки поведения, глобальные настройки и настройки атрибутов
     * @throws \Exception
     */
    public function prepareSettings()
    {
        $this->prepareAttributeSettings();
        $this->prepareCommonSettings();
    }

    /**
     * Возвращает настройки для поведения
     * @return array
     */
    public function getBehaviorSettings()
    {
        return $this->behaviorSettings;
    }


    /**
     * Возвращает настройки из приложения
     * @return array
     */
    public function getGlobalSettings()
    {
        return $this->globalSettings;
    }

    /**
     * Возвращает массив настроек для каждого аттрибута
     * @return array
     */
    public function getAttributeSettings()
    {
        return $this->attributeSettings;
    }
}