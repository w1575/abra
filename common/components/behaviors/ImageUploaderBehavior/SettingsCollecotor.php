<?php


namespace common\components\behaviors\ImageUploaderBehavior;

use Yii;
use yii\db\Exception;
use function GuzzleHttp\Psr7\uri_for;

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
     *
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
    private function prepareAttributesParams()
    {
        $params = $this->owner->attributeSettings;
        if (!is_array($params)) {
            throw new \Exception('Параметр attributeSettings должен быть массивом.');
        }

        foreach ($params as $fileAttribute => $attributeParams) {
            // берем настройки для каждого атрибута
            $this->fileAttributeNames[] = $fileAttribute;
            foreach ($this->settingNames as $index => $settingName) {
                $this->attributeSettings[$fileAttribute][$settingName] = $attributeParams[$settingName];
            }
        }
    }

    /**
     * @throws Exception
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
     * @throws Exception
     */
    private function buildFolderPath($fileAttributeName)
    {
        $path = $this->globalSettings[static::FOLDER_PATH_SETTING_NAME] ?? '';
        // TODO: очень длинные названия получаются пока что нет времени это переделывать :(

        if (isset($this->behaviorSettings[static::FOLDER_PATH_SETTING_NAME])) {
            if ($this->behaviorSettings[static::FOLDER_PATH_SETTING_NAME][0] === '@' or $this->behaviorSettings['path'][0] === DIRECTORY_SEPARATOR) {
                $path = $this->behaviorSettings[static::FOLDER_PATH_SETTING_NAME];
            } else {
                if (!empty($path)) {
                    $path .= DIRECTORY_SEPARATOR . $this->behaviorSettings[static::FOLDER_PATH_SETTING_NAME];
                } else {
                    $path = $this->behaviorSettings[static::FOLDER_PATH_SETTING_NAME];
                }
            }
        }
        // TODO: DRY тут и не пахнет
        if (isset($this->attributeSettings[$fileAttributeName][static::FOLDER_PATH_SETTING_NAME])) {
            if (
                $this->attributeSettings[$fileAttributeName][static::FOLDER_PATH_SETTING_NAME][0] === '@'
                or $this->attributeSettings[$fileAttributeName][static::FOLDER_PATH_SETTING_NAME][0] === DIRECTORY_SEPARATOR
            ) {
                $path = $this->attributeSettings[$fileAttributeName][static::FOLDER_PATH_SETTING_NAME];
            } else {
                if (!empty($path)) {
                    $path .= DIRECTORY_SEPARATOR . $this->attributeSettings[$fileAttributeName][static::FOLDER_PATH_SETTING_NAME];
                } else {
                    $path = $this->attributeSettings[$fileAttributeName][static::FOLDER_PATH_SETTING_NAME];
                }
            }
        }

        if (empty($path)) {
            throw new Exception("Для атрибута {$fileAttributeName} не указан параметр folderPath");
        }

        if (!($path[0] !== '/' and $path[0] !== '@')) {
            throw new \Exception("{$fileAttributeName}: параметр folderPath должен начинаться с '@' или '/'");
        }

    }

    /**
     * @param $fileAttributeName
     * @throws Exception
     */
    private function buildWebPath($fileAttributeName)
    {
        // TODO: нужно доработать эту копипасту метода выше
        $webPathName = static::WEB_PATH_SETTING_NAME;
        $path = $this->globalSettings[$webPathName] ?? '';

        if (isset($this->behaviorSettings[$webPathName])) {
            if ($this->behaviorSettings[$webPathName][0] === DIRECTORY_SEPARATOR) {
                $path = $this->behaviorSettings[$webPathName];
            } else {
                if (!empty($path)) {
                    $path .= "/{$this->behaviorSettings[$webPathName]}";
                } else {
                    $path = $this->behaviorSettings[$webPathName];
                }
            }
        }
        // TODO: DRY тут и не пахнет
        if (isset($this->attributeSettings[$fileAttributeName][$webPathName])) {
            if ($this->attributeSettings[$fileAttributeName][$webPathName][0] === DIRECTORY_SEPARATOR) {
                $path = $this->attributeSettings[$fileAttributeName][$webPathName];
            } else {
                if (!empty($path)) {
                    $path .= "/{$this->attributeSettings[$fileAttributeName][$webPathName]}";
                } else {
                    $path = $this->attributeSettings[$fileAttributeName][$fileAttributeName];
                }
            }
        }

        if (empty($path)) {
            throw new Exception("Для атрибута {$fileAttributeName} не указан параметр webPath");
        }

        if ($path[0] !== '/') {
            throw new \Exception("{$fileAttributeName}: параметр webPath должен начинаться с '/'");
        }

        $this->preparedSettings[$fileAttributeName]['webPath'] = $path;

    }

    /**
     * @param $fileAttributeName
     */
    private function buildNamePrefixLength($fileAttributeName)
    {
        $this->preparedSettings[$fileAttributeName]['namePrefixLength'] =
            $this->attributeSettings[$fileAttributeName]['namePrefixLength']
            ?? $this->behaviorSettings['namePrefixLength']
            ?? $this->globalSettings['namePrefixLength']
            ?? 0
        ;
    }

    /**
     * @param $fileAttributeName
     */
    private function buildReplaceDuplicate($fileAttributeName)
    {
        $name = static::REPLACE_DUPLICATE_SETTING_NAME;
        $this->preparedSettings[$fileAttributeName][$name] =
            $this->attributeSettings[$fileAttributeName][$name]
            ?? $this->behaviorSettings[$name]
            ?? $this->globalSettings[$name]
            ?? false
        ;
    }

    /**
     * @param $fileAttributeName
     */
    private function buildDeleteOnChange($fileAttributeName)
    {
        $name = static::DELETE_ON_CHANGE_SETTING_NAME;
        $this->preparedSettings[$fileAttributeName][$name] =
            $this->attributeSettings[$fileAttributeName][$name]
            ?? $this->behaviorSettings[$name]
            ?? $this->globalSettings[$name]
            ?? true
        ;
    }

    /**
     * @param $fileAttributeName
     */
    private function buildPreviewSettings($fileAttributeName)
    {
        if ($this->attributeSettings[$fileAttributeName][static::PREVIEW_SETTING_NAME] === false) {
            $this->preparedSettings[$fileAttributeName][static::PREVIEW_SETTING_NAME] = false;
        }

        foreach ($this->previewSettingNames as $index => $previewSettingName) {
            $value =
                $this->attributeSettings[$fileAttributeName][static::PREVIEW_SETTING_NAME][$previewSettingName]
                ?? $this->behaviorSettings[static::PREVIEW_SETTING_NAME][$previewSettingName]
                ?? $this->globalSettings[static::PREVIEW_SETTING_NAME][$previewSettingName]
                ?? null
            ;

            if ($value === null and $previewSettingName !== static::PREVIEW_SETTING_FOLDER_NAME) {
                // ибо подпапки для превьюшек может и не быть, а вот остальные параметры должны быть указаны
                throw new \Exception("Параметр {$previewSettingName} для атрибута {$fileAttributeName} пуст.");
            }

            $this->preparedSettings[$fileAttributeName][static::PREVIEW_SETTING_NAME][$previewSettingName] = $value;

        }
    }

    /**
     *
     */
    public function setAttributeSettings()
    {
        $this->uploader->setAttributeSettings($this->preparedSettings);
    }




}