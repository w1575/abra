<?php


namespace common\components\behaviors\ImageUploaderBehavior\models;


class PreviewSettingsModel extends \yii\base\Model
{
    /**
     * @var int ширина
     */
    public $width;
    /**
     * @var int высота
     */
    public $height;
    /**
     * @var int качество
     */
    public $quality;
    /**
     * @var int длина генерируемого префикса
     */
    public $prefixLength;
    /**
     * @var string путь, по которому будет сохраняться
     */
    public $folder;


    /**
     * @return array|void
     */
    public function rules()
    {
        return [
            [['width', 'height', 'quality', 'prefixLength'], 'integer'],
            [['folder'], 'string', 'max' => 512],
            [['quality'], 'in', 'range' => [0, 100]],
            [['prefixLength'], 'in', 'range' => [0, 64]],
            [['width', 'height', 'quality'], 'required',],
        ];
    }
}