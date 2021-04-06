<?php

namespace frontend\models\company\web;

use Yii;

/**
 * This is the model class for table "{{%web_company_service}}".
 *
 * @property int $id
 * @property string $name Название услуги
 * @property string|null $date_created Дата добавления
 * @property int|null $creator_id Создатель
 * @property int|null $status Статус [-1 - удалена, 0 - неактивна, 1- активна]
 *
 * @property User $creator
 * @property WebCompanyWebCompanyService[] $webCompanyWebCompanyServices
 * @property WebCompany[] $webCompanies
 */
class WebCompanyService extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%web_company_service}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['date_created'], 'safe'],
            [['creator_id', 'status'], 'default', 'value' => null],
            [['creator_id', 'status'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название услуги',
            'date_created' => 'Дата добавления',
            'creator_id' => 'Создатель',
            'status' => 'Статус [-1 - удалена, 0 - неактивна, 1- активна]',
        ];
    }

    /**
     * Gets query for [[Creator]].
     *
     * @return \yii\db\ActiveQuery|\frontend\models\company\web\queries\UserQuery
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
        return $this->hasMany(WebCompanyWebCompanyService::className(), ['web_company_service_id' => 'id']);
    }

    /**
     * Gets query for [[WebCompanies]].
     *
     * @return \yii\db\ActiveQuery|\frontend\models\company\web\queries\WebCompanyQuery
     */
    public function getWebCompanies()
    {
        return $this->hasMany(WebCompany::className(), ['id' => 'web_company_id'])->viaTable('{{%web_company_web_company_service}}', ['web_company_service_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \frontend\models\company\web\queries\WebCompanyServiceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \frontend\models\company\web\queries\WebCompanyServiceQuery(get_called_class());
    }
}
