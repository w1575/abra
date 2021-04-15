<?php


namespace common\components\behaviors\ImageUploaderBehavior_;

use Faker\Factory;

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
     *          'folderPath' => '/var/www/site.name/web/uploads
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
    public $namePrefixLength; //  = 8
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
    /**
     * @param $values array устанавливает атрибуты настроек для каждого атрибута файла
     */
    public function setAttributeSettings($values)
    {
        $this->attributeSettings = $values;
    }

    /**
     * Инициализация поведения
     */
    public function init()
    {
        parent::init();
        $collector = SettingCollectorFactory::build($this);
        $collector->setAttributeSettings();
        unset($collector);
        $settings = $this->attributeSettings;

        die();
    }

}