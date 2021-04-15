<?php

namespace frontend\models\company\web;

use common\components\behaviors\ImageUploaderBehavior\ImageUploaderBehavior;
use frontend\components\behaviors\ModelImageUploadBehavior;
use frontend\models\queries\UserQuery;
use Yii;
use frontend\models\User;
/**
 * This is the model class for table "{{%web_company}}".
 *
 * @property int $id
 * @property string $name Название
 * @property string|null $url Ссылка на сайт
 * @property string|null $description Описание
 * @property int|null $creator_id Создатель
 * @property int|null $status Статус
 * @property string|null $logo_path Логотип
 *
 * @property User $creator
 * @property WebCompanyWebCompanyService[] $webCompanyWebCompanyServices
 * @property WebCompanyService[] $webCompanyServices
 */
class WebCompany extends \yii\db\ActiveRecord
{

    public $logoAttribute;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%web_company}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['creator_id', 'status'], 'default', 'value' => null],
            [['creator_id', 'status'], 'integer'],
            [['name', 'url', 'description'], 'string', 'max' => 255],
            [['logo_path'], 'string', 'max' => 512],
            [
                ['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id']
            ],
            ['logoAttribute', 'file', 'skipOnEmpty' => true, 'extensions' => ['png', 'jpg', 'jpeg', 'bmp', 'gif'], 'maxFiles' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'url' => 'Ссылка на сайт',
            'description' => 'Описание',
            'creator_id' => 'Создатель',
            'status' => 'Статус',
            'logo_path' => 'Логотип',
        ];
    }

    /**
     * Gets query for [[Creator]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'creator_id']);
    }

    /**
     * Gets query for [[WebCompanyWebCompanyServices]].
     *
     * @return \yii\db\ActiveQuery|\frontend\models\company\web\queries\WebCompanyWebCompanyServiceQuery
     */
    public function getWebCompanyWebCompanyServices()
    {
        return $this->hasMany(WebCompanyWebCompanyService::className(), ['web_company_id' => 'id']);
    }

    /**
     * Gets query for [[WebCompanyServices]].
     *
     * @return \yii\db\ActiveQuery|\frontend\models\company\web\queries\WebCompanyServiceQuery
     */
    public function getWebCompanyServices()
    {
        return $this->hasMany(WebCompanyService::className(), ['id' => 'web_company_service_id'])->viaTable('{{%web_company_web_company_service}}', ['web_company_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \frontend\models\company\web\queries\WebCompanyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \frontend\models\company\web\queries\WebCompanyQuery(get_called_class());
    }

    /**
     * Подключенные поведения
     * @return array[]
     */
    public function behaviors()
    {
        return [
            'uploadImages' => [
                'class' => ImageUploaderBehavior::class,

                'attributeSettings' => [
                    'logoAttribute' => [
                        'dbAttribute' => 'logo_path',
                    ],
                ],
            ],
        ];
    }
}
