<?php


namespace common\components\behaviors\ImageUploaderBehavior\settingBuilders;


use common\components\behaviors\ImageUploaderBehavior\ImageUploaderBehavior;
use common\components\behaviors\ImageUploaderBehavior\SettingsCollecotor;

class SettingsBuilder
{
    /**
     * @var array|null массив с главными параметрами
     */
    public $majorSettings;
    /**
     * @var array|null массив с второстепенными параметрами
     */
    public $minorSettings;
    /**
     * @var SettingsCollecotor
     */
    public $collector;
    /**
     * @var array итоговые настройки
     */
    private $settings;
    /**
     * @var ImageUploaderBehavior объект поведения
     */
    public $uploader;

    /**
     * Билдим настройки
     */
    public function buildSettings()
    {
        $settingNames = $this->collector->settingNames;
        unset($settingNames[SettingsCollecotor::PREVIEW_SETTING_NAME]);
        foreach ($settingNames as $settingName) {
            $this->{"{$settingNames}Build"}();
        }
    }

    /**
     * Т.к. и путь для браузера и путь в файловой структуре билдятся одинакова, то и логику я вынес в отдельный метод
     * @param $settingName string название настройки, которую ставим
     * @param $firstSymbol string символ, который означает, что это у нас начало пути
     * @param $separator string ну и соответственно сепортор, для веба /, а на стороне сервера свой ()
     */
    private function setPath($settingName, $firstSymbol, $separator)
    {
        $majorValue = isset($this->majorSettings[$settingName]) ?? null;
        $minorValue = $this->minorSettings[$settingName] ?? null;
        if (empty($majorValue)) {
            if (empty($minorValue)) {
                $this->settings[$settingName] = null;
            } else {
                $this->settings[$settingName] = $minorValue;
            }
        } elseif(empty($minorValue)) {
            $this->settings[$settingName] = $majorValue;
        } elseif ($majorValue[0] === $firstSymbol) {
            $this->settings[$settingName] = $majorValue;
        } else {
            $this->settings[$settingName] = "{$minorValue}{$separator}{$minorValue}";
        }
    }

    /**
     * Собираем настройки веб пути
     */
    private function webPathBuild()
    {
         $this->setPath(SettingsCollecotor::WEB_PATH_SETTING_NAME, '/', '/');
    }

    /**
     * Сборка
     */
    private function folderPathBuild()
    {
        $this->setPath(SettingsCollecotor::FOLDER_PATH_SETTING_NAME, '@', DIRECTORY_SEPARATOR);
    }

    /**
     * @return bool|mixed|null
     */
    private function namePrefixLengthBuild()
    {
        $this->oneOfTwo(SettingsCollecotor::NAME_PREFIX_SETTING_NAME);
    }

    /**
     * Удалять или нет дубликаты по именам
     */
    private function replaceDuplicateBuild()
    {
        $this->oneOfTwo(SettingsCollecotor::REPLACE_DUPLICATE_SETTING_NAME);
    }

    /**
     * Удалять ли старую картинку при загрузке новой
     */
    private function deleteOnChangeBuild()
    {
        $this->oneOfTwo(SettingsCollecotor::DELETE_ON_CHANGE_SETTING_NAME);
    }

    /**
     * @param $settingName string выбирает одну из настроек и устнавливает ее как итоговую
     */
    private function oneOfTwo($settingName)
    {
        $majorValue = isset($this->majorSettings[$settingName]) ?? null;
        $minorValue = $this->minorSettings[$settingName] ?? null;
        $this->settings[$settingName] =  $majorValue ?? $minorValue;
    }

    /**
     * @return array возвращает массив сбилженных настроек
     */
    public function getSettings()
    {
        return $this->settings;
    }









}