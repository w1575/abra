<?php


namespace common\components\behaviors\ImageUploaderBehavior\models;


use common\components\behaviors\ImageUploaderBehavior\SettingsCollecotor;

class SettingsModel extends \yii\base\Model
{
    /**
     * Отдельный сценарий, т.к. у нас непосредственно в настройках атриубтуов должен
     * быть обязательно установлен атрибут в который у нас будет записываться имя (путь)
     * загруженного файла
     */
    public const SCENARIO_FILE_ATTRIBUTE_VALIDATE = 'validateFileAttribute';
    /**
     * Итоговая валидация собранных настроек для каждого атрибута
     */
    public const SCENARIO_FINAL = 'finalValidate';
    /**
     * @var
     */
    public $previewSettings;
    /**
     * @var
     */
    public $webPath;
    /**
     * @var
     */
    public $folderPath;
    /**
     * @var
     */
    public $namePrefixLength;
    /**
     * @var
     */
    public $replaceDuplicate;
    /**
     * @var
     */
    public $deleteOnChange;
    /**
     * @var
     */
    public $dbAttribute;

    /**
     * @return array
     */
    public function rules()
    {
        switch ($this->scenario) {
            case static::SCENARIO_FINAL:
                return $this->getFinalRules();
            default:
                return $this->getDefultRules();
        }
    }

    /**
     * @return array
     */
    private function getDefultRules()
    {
        return [
            [
                SettingsCollecotor::PREVIEW_SETTING_NAME,
                'isArrayValidator'
            ],
            [
                SettingsCollecotor::WEB_PATH_SETTING_NAME,
                'string',
                'max' => 256,
                'skipOnEmpty' => true
            ],
            [
                SettingsCollecotor::FOLDER_PATH_SETTING_NAME,
                'string',
                'max' => 512,
                'skipOnEmpty' => true,
            ],
            [
                SettingsCollecotor::NAME_PREFIX_SETTING_NAME,
                'in',
                'range' => [
                    0,
                    32
                ]
            ],
            [
                [
                    SettingsCollecotor::DELETE_ON_CHANGE_SETTING_NAME,
                    SettingsCollecotor::REPLACE_DUPLICATE_SETTING_NAME
                ],
                'boolean'
            ],
        ];
    }

    /**
     * Правила, которые нужны для проверки итоговых настроек аттрибута
     * @return array
     */
    private function getFinalRules()
    {
        return [
            [
                SettingsCollecotor::WEB_PATH_SETTING_NAME,
                'string',
                'max' => 512,
                'skipOnEmpty' => false
            ],
            [
                SettingsCollecotor::WEB_PATH_SETTING_NAME,
                'firstSymbolIsSlashValidator',
                'skipOnError' => true,
            ],
            [
                SettingsCollecotor::FOLDER_PATH_SETTING_NAME,
                'string',
                'max' => 1024,
                'skipOnEmpty' => false,
            ],
            [
                SettingsCollecotor::FOLDER_PATH_SETTING_NAME,
                'firstSymbolIsSlashOrAtValidator',
                'skipOnEmpty' => true,
            ],
            [
                SettingsCollecotor::NAME_PREFIX_SETTING_NAME,
                'in',
                'range' => [
                    0,
                    32
                ]
            ],
            [
                [
                    SettingsCollecotor::DELETE_ON_CHANGE_SETTING_NAME,
                    SettingsCollecotor::REPLACE_DUPLICATE_SETTING_NAME
                ],
                'boolean',
                'skipOnEmpty' => false,
            ],
            [
                SettingsCollecotor::PREVIEW_SETTING_NAME,
                'previewParamsValidator',
                'skipOnError' => true,
            ],
        ];
    }

    /**
     * На некоторых этапах нам нужно узнать, что настройка является массивом
     * и больше ничего.
     * @param $attribute string название атрибута
     * @param  $params array параметры валидатора
     */
    public function isArrayValidator($attribute, $params){

        $skipOnEmpty = $params['skipOnEmpty'] ?? true;

        if ($skipOnEmpty !== true and !empty($this->{$attribute})) {
            if(!is_array($this->{$attribute})){
                $this->addError($attribute,"{$attribute} не является массивом");
            }
        }
    }

    /**
     * Проверяет является ли первый символ пути, по которому сохраняется директория / или @
     * @param $attribute
     * @param $params
     */
    public function firstSymbolIsSlashOrAtValidator($attribute, $params)
    {
        if (!($this->hasErrors() and $params['skipOnError'] === true)) {
            $value = $this->{$attribute};
            if ($value[0] !== '@' and $value[0] !== '/') {
                $this->addError(
                    $attribute,
                    'Первый символ должен начинаться с @ или /'
                );
            }
        }
    }

    /**
     * Проверяет является ли первый символ пути, по которому сохраняется директория / или @
     * @param $attribute
     * @param $params
     */
    public function firstSymbolIsSlashValidator($attribute, $params)
    {
        if (!($this->hasErrors() and $params['skipOnError'] === true)) {
            $value = $this->{$attribute};
            if ($value[0] !== '/') {
                $this->addError(
                    $attribute,
                    'Первый символ должен начинаться с @ или /'
                );
            }
        }
    }

    /**
     * Проверяет настройки для превьюшек изоабражений
     * @param $attribute
     * @param $params
     */
    public function previewParamsValidator($attribute, $params)
    {
        if (!($this->hasErrors() and !$params['skipOnError'])) {
            $values = $this->{$attribute};
            if (!empty($values)) {
                $model = new PreviewSettingsModel($values);
                if (!$model->validate()) {
                    foreach ($model->errors as $previewAttribute => $error) {
                        $this->addError($previewAttribute, $error);
                    }
                }
            }
            // может быть пустым, в таком случае просто превьюшка не будет генерироваться
        }
    }

}