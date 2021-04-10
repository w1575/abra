<?php


namespace common\components\behaviors\ImageUploaderBehavior;

use Yii;
use yii\db\Exception;
use function GuzzleHttp\Psr7\uri_for;

/**
 * Class SettingsCollecotor если честно я не знаю что и зачем я делаю :D
 * Но интересно попробовать. Этот класс будет отвечать
 * @package common\components\behaviors\ImageUploaderBehavior
 */
class SettingsCollecotor extends \yii\base\Component
{
    public const PREVIEW_SETTINGS_NAME = 'previewSettings';

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
    private $attributeParams = [];
    /**
     * Список параметров
     * @var string[]
     */
    private $settingNames = [
        'webPath',
        'folderPath',
        'namePrefixLength',
        'replaceDuplicate',
        'deleteOnChange',
        'previewSettings',
    ];
    /**
     * @var string[]
     */
    private $previewSettingNames = [
        'width',
        'height',
        'quality',
        'prefixLength',
        'folder',
    ];

    /**
     * @param $uploader
     */
    public function setUploader($uploader)
    {
        $this->uploader = $uploader;
        $this->prepareSettings();
    }

    /**
     * Подготавливает все виды настройки поведения
     */
    private function prepareSettings()
    {
        $this->prepareGlobalSettings();
        $this->prepareBehaviorSettings();
        $this->prepareAttributesSettings();
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
                throw new \Exception('Параметр ' . static::PREVIEW_SETTINGS_NAME .' не может иметь значение true');
            case 'array':
                $result = [];
                foreach ($this->previewSettingNames as $index => $previewSettingName) {
                    $result[$previewSettingName] = $settings[$previewSettingName] ?? null;
                }
                return $result;
            default:
                throw new \Exception('Параметр ' . static::PREVIEW_SETTINGS_NAME  . ' имеет неверный формат.');
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
                $this->globalSettings[static::PREVIEW_SETTINGS_NAME] = $this->preparePreviewSettings($this->globalSettings[static::PREVIEW_SETTINGS_NAME]);
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
            $this->behaviorSettings[static::PREVIEW_SETTINGS_NAME]
                = $this->preparePreviewSettings($this->behaviorSettings)
            ;
        } catch (\Exception $e) {
            throw new \Exception("При проверке параметров поведения произошла ошибка: {$e->getMessage()}");
        }

    }

    /**
     * Получение индивидуальных настроек атрибутов
     */
    private function prepareAttributesParams()
    {
        $params = $this->owner->attributesSettings;
        if (!is_array($params)) {
            throw new \Exception('Параметр attributesSettings должен быть массивом.');
        }

        foreach ($params as $fileAttribute => $attributeParams) {
            foreach ($this->settingNames as $index => $settingName) {
                $actualValue= $attributeParams[$settingName]
                    ?? (
                        $this->behaviorSettings[$settingName]
                        ?? $this->globalSettings[$settingName]
                    )
                ;

                if ($actualValue === null) {
                    throw new Exception("Параметр {$settingName} не может быть равен NULL");
                }
                $this->attributeParams[$fileAttribute][$settingName] = $actualValue;
            }
        }



    }

    public function setAttributesSettings()
    {

    }


}