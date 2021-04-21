<?php


namespace common\components\behaviors\ImageUploaderBehavior\settingBuilders;


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

    public function buildSettings()
    {
        $settingNames = $this->collector->settingNames;
        unset($settingNames[SettingsCollecotor::PREVIEW_SETTING_NAME]);
        foreach ($settingNames as $settingName) {
            $this->{"{$settingNames}Build"}();
        }
    }

    private function webPathBuild()
    {
        $settingName = SettingsCollecotor::WEB_PATH_SETTING_NAME;
        $majorValue = null;
        if (isset($this->majorSettings[$settingName])) {
            if ($this->majorSettings[$settingName][0] === '/') {
                $this->settings[$settingName] = $this->majorSettings[$settingName];
                return true;
            } else {
                $majorValue = "/{$this->majorSettings[$settingName]}";
            }
        }

        if (isset($this->minorSettings[$settingName])) {
            $this->settings[$settingName] =  "{$this->minorSettings[$settingName]}" . ($majorValue ?? "");
            return true;
        } else {

        }



    }

    private function folderPathBuild()
    {

    }

    private function namePrefixLengthBuild()
    {

    }

    private function replaceDuplicateBuild()
    {

    }

    private function deleteOnChangeBuild()
    {

    }









}