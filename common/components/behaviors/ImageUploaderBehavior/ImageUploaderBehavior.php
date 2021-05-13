<?php


namespace common\components\behaviors\ImageUploaderBehavior;

use common\components\behaviors\ImageUploaderBehavior\factories\SettingCollectorFactory;
use common\components\behaviors\ImageUploaderBehavior\factories\SettingsBuilderFactory;
use Faker\Factory;
use yii\base\Model;
use yii\db\ActiveRecord;
use Yii;
use Imagine\Image\Box;

/**
 * Class ImageUploaderBehavior позволяет загружать файлы на сервер и записывать путь в колонку
 * модели. Иерархия настроек такая:
 * 1. Настройки, которые находятся в параметрах конфига приложения (params)
 * 2. Настройки, которые указаны непосредственно при подключении поведения
 * 3. Настройки для каждого конкретного атрибута.
 * Чем ниже в иерархии настройки, тем выше у них приоритет (настройки для отдельного атрибута
 * перекрывают настройки для поведения, а те, в свою очередь, перекрывают настройки, указанные
 * в параметрах приложения)
 * @package common\components\behaviors\ImageUploaderBehavior
 */
class ImageUploaderBehavior extends \yii\base\Behavior
{
    /**
     * @var string путь до сервера изображений, по-умолчанию текущий адрес сайта параметр должен соответствовать
     * файловой структуре, указанной в параметре $folderPath
     */
    public $webPath; // = '/'
    /**
     * @var string адрес к директории на сервере, в которую будут записаны файлы. Путь должен
     * начинаться либо с "/" (корень файловой структуры сервера), либо с "@" (плияс директории yii2)
     * Если начать без этих символов, то поведение будет предполагать, что это поддиректория и,
     * пытаться добавить ее к настройкам директории, которая находится в иерархии выше
     * 1. Настройки, указанные в параметрах приложения
     * 2. Настройки, указанные в параметрах поведения, при подключении его к модели
     * 3. Настройки атрибута
     * @example  Небольшой пример
     * Параметры приложения
     * 'params' => [
     *      // ... другие параметры приложения
     *      'imageUploadBehavior' => [
     *          'folderPath' => '@frontend/web/uploads
     *      ]
     * ]
     * Подключение приложения
     * [
     *     'class' => ImageUploaderBehavior::class,
     *     'folderPath' => '@frontend/web/images',
     *     'attributes' => [
     *         'logoFile' => [
     *              'dbAttribute' => 'logo_path',
     *              'folderPath' => 'logos',
     *          ]
     *      ],
     * ]
     * В данном случае настройки, указанные параметрах приложения будут проигнорированы, а файлы
     * будут загружены по адресу @frontend/web/images/logos
     * Как минимум один из способов настройки должен быть указан. Если получается так, что путь к директории
     * не начинается с "@" или с "/", то будет выброшено исключение.
     */
    public $folderPath;
    /**
     * @var int длина генерируемого префикса для загружаемого файла, если указан 0, то
     * префикс не будет сгенерирован
     * @example  для файла с именем image_17.png будет сгенерировано имя 0du87dnm_image_17.png
     */
    public $namePrefix; //  = 8
    /**
     * @var bool если указан false, то к имени файла будет добавляться произвольный суффикс
     */
    public $replaceDuplicate; //  = false
    /**
     * @var bool удалять или нет файл, если загружается новый
     */
    public $deleteOnChange; //  = true
    /**
     * @var array|false настройки превьюшек изображения. Если указан false, то превью не будет сгенерирована
     */
    public $previewSettings = [
//        'width' => 120, // ширина
//        'height' => 120, // высота
//        'quality' => 90, // качество превьюшки
//        'prefixLength' => 0, // такой же принцип, как я описал выше
//        'folder' => 'preview', // принцип такой же как и у параметра folderPath, по умолчанию записывается в подкаталог

    ];
    /**
     * @var array настройки параметров для каждого атрибута модели. Все параметры такие же, как
     * и глобальные. Единственным обязательным параметром является dbAttribute, именно в него
     * будет записан путь к файлу на сервере. Путь будет относительным. При формировании
     * будет взят путь из folderPath.
     * @example
     *  'class' => ImageUploaderBehavior::class,
     *     'folderPath' => '@frontend/web/images',
     *     'attributeParams' => [
     *         'logoFile' => [
     *              'dbAttribute' => 'logo_path',
     *          ]
     *      ],
     * ]
     *
     */
    public $attributeParams = [];
    /**
     * @var array подготовленные настройки для каждого атрибута
     */
    private $attributeSettings  = [];
//    /**
//     * @var bool загружать ли автоматически после успешной валидации
//     */
//    public $uploadAfterValidate;

    /**
     * @param $values array устанавливает атрибуты настроек для каждого атрибута файла
     */
    public function setAttributeSettings($values)
    {
        $this->attributeSettings = $values;
    }

    /**
     * @return array
     */
    public function getAttributeSettings()
    {
        return $this->attributeSettings;
    }

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_VALIDATE => 'uploadImages',
            ActiveRecord::EVENT_AFTER_DELETE => 'deleteImagesAfterItemDeleted',
        ];
    }

    /**
     * Инициализация поведения
     */
    public function init()
    {
        $collector = SettingCollectorFactory::build($this);
        $collector->prepareSettings();

        $globalSettings = $collector->getGlobalSettings();
        $behaviorSettings = $collector->getBehaviorSettings();
        $commonSettingsModel = SettingsBuilderFactory::build($behaviorSettings, $globalSettings, $collector);

        $commonSettings = $commonSettingsModel->getSettings();

        $attributeSettings = $collector->getAttributeSettings();
        foreach ($attributeSettings as $attributeName => $attributeSetting) {
            $finalSettingsBuilder = SettingsBuilderFactory::build($attributeSetting, $commonSettings, $collector);
            $this->attributeSettings[$attributeName] = $finalSettingsBuilder->getSettings();
            $dbAttributeName = $attributeSetting[SettingsCollecotor::DB_ATTRIBUTE_NAME] ?? null;
            if (empty($dbAttributeName)) {
                throw new \Exception('Не указан параметр ' . SettingsCollecotor::DB_ATTRIBUTE_NAME);
            }
            $this->attributeSettings[$attributeName][SettingsCollecotor::DB_ATTRIBUTE_NAME] = $dbAttributeName;
        }
    }



    /**
     * Тестовый метод, чтобы посмотреть какие настройки получились в итоге
     */
    public function showAllSettings()
    {
        echo '<pre>';
        var_dump($this->attributeSettings);
        echo '</pre>';
    }


    public function getPreviewLink()
    {

    }

    private function getFilePath()
    {

    }

    /**
     *
     * @return bool
     */
    public function uploadImages()
    {
        /* @var $ownerModel ActiveRecord */
        $ownerModel = $this->owner;
        if ($ownerModel->hasErrors()) {
            // если модель не прошла валидацию, то и нет смысла
            // что-то загружать, ведь так?
            return false;
        }

        foreach ($this->attributeSettings as $attributeName => $attributeSetting) {
            // в приницпе можно просто выбрать ключи из массива и пробежаться по ним
            // НО в приницпе пока что оставлю так

            if ($ownerModel->{$attributeName} === null) {
                // для данного аттрибута ничего не загружено
                continue;
            }

            $oldValue = $ownerModel->{$attributeSetting[SettingsCollecotor::DB_ATTRIBUTE_NAME]};
            if (!empty($oldValue) and $attributeSetting[SettingsCollecotor::DELETE_ON_CHANGE_SETTING_NAME] === true) {
                // если предположительно существует старый файл, и нужно вместо него поставить новый
                $this->deleteImage($attributeName);
            }

            $this->saveImage($attributeName);
            $this->generatePreview($attributeName);




        }
    }

    /**
     * Удаляет файл
     * @param $attributeName
     */
    public function deleteImage($attributeName)
    {
        die('Сделать удаление файла');
    }

    /**
     * Генерирует название файла для нового файла и возвращает полный путь к нему
     * @param $name string название атрибута
     * @return string полный путь к файлу в файловой системе
     * @throws \yii\base\Exception
     * @return string путь к новому файлу
     */
    private function generateFileFullPath($name)
    {
        $settings = $this->attributeSettings[$name];
        $prefixLength = (int)$settings[SettingsCollecotor::NAME_PREFIX_SETTING_NAME] ?? 0;
        if ($prefixLength > 0) {
            $prefix = \yii::$app->security->generateRandomString($prefixLength);
            $fileName = "{$prefix}_{$name}" ;
        }

        $folderPath = $settings[SettingsCollecotor::FOLDER_PATH_SETTING_NAME];
        $this->createFolderIfNotExist($folderPath);

        return $folderPath . DIRECTORY_SEPARATOR . $fileName;
    }

    /**
     * @param $attributeName
     * @param $settings
     * @throws \yii\base\Exception
     */
    private function saveImage($attributeName)
    {
        $ownerModel = $this->owner;
        $old = umask(0);
        $fileName = $fileName = $this->owner->{$attributeName}->baseName;
        $fullPath = $this->generateFileFullPath($fileName);
        $ownerModel->{$attributeName}->saveAs($fullPath);
        $dbAttributeName = $this->attributeSettings[$attributeName][SettingsCollecotor::DB_ATTRIBUTE_NAME];
        $ownerModel->{$dbAttributeName} = $fileName;

        umask($old);
    }

    /**
     * Возвращает путь к картинке на стороне сервера
     * @param $attributeName
     * @return mixed|null
     */
    public function getImageServerPath($attributeName)
    {
        $settings = $this->attributeSettings[$attributeName];
        $dbAttribute = $settings[SettingsCollecotor::DB_ATTRIBUTE_NAME];
        $fileName = $this->owner->{$dbAttribute};
        return $fileName === null
            ? null
            : $settings[SettingsCollecotor::FOLDER_PATH_SETTING_NAME] . DIRECTORY_SEPARATOR . $fileName
        ;
    }

    /**
     * Удаляет картинку и, если есть, превьюшку изображения после удаления записи
     */
    public function deleteImagesAfterItemDeleted()
    {
        foreach ($this->attributeSettings as $attributeName => $attributeSetting) {
            $path = $this->getImageServerPath($attributeName);
            if ($path !== null) {
                if (unlink($path) === false) {
                    Yii::$app->session->setFlash('warning', "Не удалось удалить {$path}");
                }
            }
        }
    }

    /**
     * Создает и сохраняет превью для изображения
     * @param $attributeName
     * @throws \Exception
     */
    private function generatePreview($attributeName)
    {
        $previewSettings = $this->attributeSettings[$attributeName][SettingsCollecotor::PREVIEW_SETTING_NAME] ?? false;
        if ($previewSettings !== false) {
            $subFolder = $previewSettings[SettingsCollecotor::PREVIEW_SETTING_FOLDER_NAME] ?? false;
            $namePrefix = $previewSettings[SettingsCollecotor::PREVIEW_SETTING_IMAGE_PREFIX_NAME] ?? false;
            if ($subFolder === false and $namePrefix === false) {
                $previewSubFolderName = SettingsCollecotor::PREVIEW_SETTING_FOLDER_NAME;
                $previewPrefixName = SettingsCollecotor::PREVIEW_SETTING_IMAGE_PREFIX_NAME;
                throw new \Exception("Для превью должен быть указан как минимум один из атрибутов: {$previewSubFolderName} или {$previewPrefixName}");
            }

            $name = ($namePrefix ?? '') . $this->{$attributeName};

            $width = $previewSettings[SettingsCollecotor::PREVIEW_SETTING_WIDTH_NAME];
            $height = $previewSettings[SettingsCollecotor::PREVIEW_SETTING_HEIGHT_NAME];
            $quality = $previewSettings[SettingsCollecotor::PREVIEW_SETTING_QUALITY_NAME];

        }
    }

    /**
     * Создает папку, если ее не существует в файловой системе
     * @param $folderPath
     */
    private function createFolderIfNotExist($folderPath)
    {
        if (is_dir($folderPath) === false) {
            $old = umask(0);
            $isCreated = mkdir($folderPath);
            umask($old);
            if ($isCreated === false) {
                throw new \Exception("Не удалось создать папку {$folderPath}");
            }
        }
    }




}