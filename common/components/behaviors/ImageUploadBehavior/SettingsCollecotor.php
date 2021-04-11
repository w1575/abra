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
     * @var array подготовленные настройки для каждого атрибута файлов
     */
    private $preparedSettings;
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
     * Подготавливает все виды настройки поведения
     */
    public function prepareSettings()
    {
        $this->prepareGlobalSettings();
        $this->prepareBehaviorSettings();
        $this->prepareAttributesSettings();
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
            // берем настройки для каждого атрибута
            $this->fileAttributeNames[] = $fileAttribute;
            foreach ($this->settingNames as $index => $settingName) {
                $this->attributeParams[$fileAttribute][$settingName] = $attributeParams[$settingName];
            }
        }
    }

    /**
     * Создает массив с настройками для каждого атрибуты
     */
    public function buildSettings()
    {
        foreach ($this->fileAttributeNames as $index => $fileAttributeName) {
            $this->buildWebPath($fileAttributeName);
            $this->buildFolderPath($fileAttributeName);
            $this->buildNamePrefixLength($fileAttributeName);
            $this->buildReplaceDuplicate($fileAttributeName);
            $this->buildDeleteOnChange($fileAttributeName);
            $this->buildPeviewSettings($fileAttributeName);
        }
    }

    /**
     * @param $fileAttributeName
     */
    private function buildWebPath($fileAttributeName)
    {
        $this->preparedSettings['fileAttributeName'] =
            $this->attributeParams['webPath']
            ?? $this->behaviorSettings['webPath']
            ?? $this->globalSettings['webPath']
        ;
    }

    private function buildFolderPath($fileAttributeName)
    {
        $fullPath = '';
        if ($this->attributeParams['folderPath'][0] === '/') {
            $fullPath = $this
        }
    }

    private function buildNamePrefixLength($fileAttributeName)
    {

    }

    private function buildReplaceDuplicate($fileAttributeName)
    {

    }

    private function buildDeleteOnChange($fileAttributeName)
    {

    }

    private function buildPeviewSettings($fileAttributeName)
    {

    }

    public function setAttributesSettings()
    {
        $this->uploader->setAttributeSettings($this->preparedSettings);
    }


}