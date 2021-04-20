<?php


namespace common\components\behaviors\ImageUploaderBehavior;

use common\components\behaviors\ImageUploaderBehavior\factories\SettingsModelFactory;
use common\components\behaviors\ImageUploaderBehavior\model\SettingsModel;
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
     * @var array параметры, которые указаны в настройках атрибутов
     */
    private $attributeSettings= [];
    /**
     * Список параметров
     * @var string[]
     */
    private $settingNames = [
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
    private $previewSettingNames = [
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
     * Подготавливает все виды настройки поведения
     */
    public function prepareSettings()
    {
        $this->prepareGlobalSettings();
        $this->prepareBehaviorSettings();
        $this->prepareAttributeSettings();
        $this->buildSettings();
    }

    /**
     * Подготавливает настройки для генерации превьюшек
     * @param $settings
     * @return array|false|null
     * @throws \Exception
     */
    private function preparePreviewSettings($settings)
    {
        switch (gettype($settings)) {
            case 'NULL':
                return null;
            case 'boolean':
                if ($settings === false) {
                    return false;
                }
                throw new \Exception('Параметр ' . static::PREVIEW_SETTING_NAME .' не может иметь значение true');
            case 'array':
                $result = [];
                foreach ($this->previewSettingNames as $index => $previewSettingName) {
                    $result[$previewSettingName] = $settings[$previewSettingName] ?? null;
                }
                return $result;
            default:
                throw new \Exception('Параметр ' . static::PREVIEW_SETTING_NAME  . ' имеет неверный формат.');
        }
    }

    /**
     * Подготовка настроек, указанных в параметре приложения
     * @throws \Exception
     */
    private function prepareGlobalSettings()
    {
        $globalSettings = Yii::$app->params['imageUploaderBehavior'] ?? [];
        if (!empty($globalSettings)) {
            foreach ($this->settingNames as $index => $settingName) {
                $this->globalSettings[$settingName] = $globalSettings[$settingName] ?? null;
            }
            try {
                $this->globalSettings[static::PREVIEW_SETTING_NAME] = $this->preparePreviewSettings($this->globalSettings[static::PREVIEW_SETTING_NAME]);
            } catch (\Exception $e) {
                throw new \Exception("При проверке глобальных параметров произошла ошибка: {$e->getMessage()}");
            }

        }
    }

    /**
     * Получение параметров
     * @throws \Exception при неправильной настройки параметров превьюшки
     */
    private function prepareBehaviorSettings()
    {
        $this->behaviorSettings = [];
        foreach ($this->settingNames as $index => $settingName) {
            $this->behaviorSettings[$settingName] = $this->uploader->{$settingName};
        }

        try {
            $this->behaviorSettings[static::PREVIEW_SETTING_NAME]
                = $this->preparePreviewSettings($this->behaviorSettings)
            ;
        } catch (\Exception $e) {
            throw new \Exception("При проверке параметров поведения произошла ошибка: {$e->getMessage()}");
        }

    }

    /**
     * Получение индивидуальных настроек атрибутов
     */
    private function prepareAttributeSettings()
    {
        $uploader = $this->uploader;
        $params = $uploader->getAttributeSettings();
        if (!is_array($params)) {
            throw new \Exception('Параметр attributeSettings должен быть массивом.');
        }

        foreach ($params as $fileAttribute => $attributeParams) {
            // берем настройки для каждого атрибута
            $this->fileAttributeNames[] = $fileAttribute;
            foreach ($this->settingNames as $index => $settingName) {
                $this->attributeSettings[$fileAttribute][$settingName] = $attributeParams[$settingName] ?? [];
            }
        }
    }

    /**
     * @throws Exception
     */
    public function validateSettings()
    {
        $globalSettings = SettingsModelFactory::build($this->globalSettings);
        $behaviorSettings = SettingsModelFactory::build($this->behaviorSettings);

    }

    /**
     * @throws Exception
     */
    public function buildSettings()
    {
    }



    /**
     *
     */
    public function setAttributeSettings()
    {
        $this->uploader->setAttributeSettings($this->preparedSettings);
    }




}