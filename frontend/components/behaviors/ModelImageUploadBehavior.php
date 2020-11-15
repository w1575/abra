<?php


namespace frontend\components\behaviors;


use Imagine\Image\Box;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\web\UploadedFile;

class ModelImageUploadBehavior extends \yii\base\Behavior
{
    /**
     * @var string|bool директория, в которой будут храниться удаленные файлы, если указан false, то файлы будут
     * удалять сосвсем
     * @example  '@frontend/web/uploads/deleted'
     */
    public $trashFolder = '@frontend/web/uploads/deleted';
    /**
     * @var string путь к папке
     */
    public $webPath;
    /**
     * @var string глобальный путь, по которому будут сохранятся все файлы модели
     * Например '/uploads/avatars'
     */
    public $globalPath;
    /**
     * @var int длина генерируемого префикса загружаемого файла
     */
    public $filePrefixLength = 0;
    /**
     * @var int ширина изображения
     */
    public $imgWidth;
    /**
     * @var int высота изображения
     */
    public $imgHeight;
    /**
     * @var int значение качества при сжатии
     */
    public $quality = 85;
    /**
     * @var string название события, после которого должна выполняться загрузка файла
     */
    public $uploadEventName = ActiveRecord::EVENT_AFTER_VALIDATE;
    /**
     * @var bool необходимо ли удалять предыдущий файл
     */
    public $deletePrevious = true;
    /**
     * @var string название ивента по которому нужно удалить изображение
     */
    public $deleteImageEvent = ActiveRecord::EVENT_BEFORE_DELETE;
    /**
     * @var string аттрибут, который должен проверяться для удаления
     */
    public $deleteFileAttribute;
    /**
     * Массив вида
     * [
     *      'imageAttribute' => [
     *          'dbAttribute' => 'logo_path', // колонка в базе, в которую нужно записать путь к файлу (будет записано имя файла)
     *          'subFolder' => '/filePreview' // субдиректория, в которую нужно переместить файл
     *          'folderPath' => 'frontend/web/uploads', // путь к папке, если указан, то будет игнорирован глобальный     *
     *          'width' => 125 // ширина ,
     *          'height' => 65 // высотка изображения,
     *          'webPath' => '/avatars/previews' - путь по которому хранятся изображения данного аттрибута
     *          // если файл не явялется изображением, то соответствено эти параметры не будут учитываться
     *
     *      ],
     *      // можно указать несколько путей к файлу, например если есть превью картинок
     *      //
     * ]
     * @var array
     */
    public $attributesSetting = [];

    /**
     * @return array
     */
    public function events()
    {
        $events = parent::events();
        if ($this->uploadEventName !== false) {
            $events[$this->uploadEventName] = 'uploadFiles';
        }
        $events[ActiveRecord::EVENT_BEFORE_VALIDATE] = 'setInstances';
        return $events;
    }


    /**
     * Делаем штуки при инициализации
     * @throws \Exception
     */
    public function init()
    {
        if (empty($this->attributesSetting)) {
            throw new \Exception('Неверная конфигурация поведения: \'attributeSetting\' не может быть пустым');
        }

        foreach ($this->attributesSetting as $index => $attributeSetting) {
            $this->validateGlobalParam('webPath', $attributeSetting);
            $this->validateGlobalParam('globalPath', $attributeSetting);
        }


    }

    /**
     * Проверка устновки глобальных параметров.
     * @param $paramName
     * @param $attrbiteSetting
     * @throws \Exception
     */
    private function validateGlobalParam($paramName, $attrbiteSetting)
    {
        if (empty($this->$paramName) and empty($attrbiteSetting[$paramName])) {
            throw new \Exception("Неверная конфигурация поведения: {$paramName} должен быть установлен как минимум глобально");
        }
    }

    /**
     * Устаналвивает экземпляр UploadedFile в соответствующие им аттриубуты модели-владельца
     */
    public function setInstances()
    {
        foreach ($this->attributesSetting as $fileAttribute => $attributeSetting) {
            $this->owner->logoFile = UploadedFile::getInstance($this->owner, $fileAttribute);
        }

    }

    /**
     * Возвращает префикс для загруженного файла
     * @return string
     * @throws \yii\base\Exception
     */
    public function getPrefix()
    {
        $length = (int)$this->filePrefixLength;
        if ($length > 0) {
            return \yii::$app->security->generateRandomString($length) . "_";
        }

        return '';
    }

    /**
     * Изменяет размер и качество загруженного изображения.
     * @param $filePath
     * @param $params
     * @return bool
     */
    public function resizeImage($filePath, $params)
    {
        $width = $params['width'] ?? $this->imgWidth;
        $height = $params['height'] ?? $this->imgHeight;
        if ((int)$width === 0 or (int)$height === 0 ) {
            return true;
        }

        $imagine = Image::getImagine();
        $thumb = $imagine->open($filePath);
        $thumb->resize(
                new Box($width, $height)
            )
            ->save(
                $filePath,
                [
                    'quality' => $this->quality
                ]
            );
    }


    /**
     * @return false
     * @throws \yii\base\Exception
     */
    public function uploadFiles()
    {
        if ($this->owner->hasErrors() === false) {
            $uploadedList = [];
            foreach ($this->attributesSetting as $fileAttribute => $attributeSetting) {
                $imageInstance = $this->owner->$fileAttribute;
                if ($imageInstance !== null) {
                    $filePath =
                        ($attributeSetting['folderPath'] ?? $this->globalPath)
                        . ($attributeSetting['subFolder'] ?? '')
                    ;

                    $filePath = \yii::getAlias("@{$filePath}");

                    $fileName =
                        $this->getPrefix()
                        ."{$imageInstance->name}";
                    $fullPath = $filePath . "/{$fileName}";
                    $uploaded = $imageInstance->saveAs($fullPath);

                    if ($uploaded === true) {
                        if (isset($attributeSetting['dbAttribute'])) {
                            $this->owner->{$attributeSetting['dbAttribute']} = $fileName;
                        }

                        $uploadedList =  $filePath . $fileName;
                        // добавляем полный путь к загруженному файлу в массив, чтобы в случае, если оди из других файлов
                        // не будет загружен можно было загруженные быстренько удалить
                        $this->resizeImage($fullPath, $attributeSetting);
                    } else {
                        $this->owner->addError(
                            $fileAttribute,
                            "Не удалось загрузить файл {$imageInstance->name}."
                        );
                        foreach ($uploadedList as $index => $item) {
                            \unlink($item);
                        }

                        return false;
                    }

                }
            }
        }
    }

    /**
     * Возвращает ссылку на загруженный файл (доступную из веб)
     * @param $attributeName
     * @throws \Exception
     */
    public function getImageUrl($attributeName)
    {
        $attributeSetting = $this->attributesSetting[$attributeName];
        if (! isset($attributeSetting) or empty($attributeSetting)) {
            throw new \Exception('Настроек для данного аттриубута не найдено');
        }

        if (!isset($attributeSetting['dbAttribute'])) {
            throw new \Exception("Вам нужно указать аттрибут, в котором хранится имя загруженного файла.");
        }
        $attribute = $attributeSetting['dbAttribute'];

        if (empty($this->owner->{$attribute})) {
            return null;
        }

        $webPath =
            ($attributeName['webPath'] ?? $this->webPath)
            . (isset($attributeSetting['subFolder']) ?? '')
        ;

        return $webPath . "/{$this->owner->{$attribute}}";

    }


}