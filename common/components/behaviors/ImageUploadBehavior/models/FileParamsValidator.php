<?php


namespace common\components\behaviors\ImageUploaderBehavior;


class FileParamsValidator extends \yii\base\Model
{
    /**
     * @var string
     */
    public $webPath;
    /**
     * @var string
     */
    public $folderPath;
    /**
     * @var string
     */
    public $namePrefixLength;
    /**
     * @var string
     */
    public $replaceDuplicate;
    /**
     * @var bool
     */
    public $deleteOnChange;
    /**
     * @var array
     */
    public $previewSettings;
    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            ['webPath', 'webPathValidator'],
            ['folderPath', 'folderPathValidator'],
            ['namePrefixLength', 'namePrefixLengthValidator'],
            ['replaceDuplicate', 'replaceDuplicateV'],
            ['deleteOnChange', 'deleteOnChangeValidator'],
            ['previewSettings', ''],
        ];
    }

}