<?php

namespace frontend\models\company\web;

use Yii;

/**
 * This is the model class for table "{{%web_company_web_company_service}}".
 *
 * @property int $web_company_id
 * @property int $web_company_service_id
 *
 * @property WebCompany $webCompany
 * @property WebCompanyService $webCompanyService
 */
class WebCompanyWebCompanyService extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%web_company_web_company_service}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['web_company_id', 'web_company_service_id'], 'required'],
            [['web_company_id', 'web_company_service_id'], 'default', 'value' => null],
            [['web_company_id', 'web_company_service_id'], 'integer'],
            [['web_company_id', 'web_company_service_id'], 'unique', 'targetAttribute' => ['web_company_id', 'web_company_service_id']],
            [['web_company_id'], 'exist', 'skipOnError' => true, 'targetClass' => WebCompany::className(), 'targetAttribute' => ['web_company_id' => 'id']],
            [['web_company_service_id'], 'exist', 'skipOnError' => true, 'targetClass' => WebCompanyService::className(), 'targetAttribute' => ['web_company_service_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'web_company_id' => 'Web Company ID',
            'web_company_service_id' => 'Web Company Service ID',
        ];
    }

    /**
     * Gets query for [[WebCompany]].
     *
     * @return \yii\db\ActiveQuery|\frontend\models\company\web\queries\WebCompanyQuery
     */
    public function getWebCompany()
    {
        return $this->hasOne(WebCompany::className(), ['id' => 'web_company_id']);
    }

    /**
     * Gets query for [[WebCompanyService]].
     *
     * @return \yii\db\ActiveQuery|\frontend\models\company\web\queries\WebCompanyServiceQuery
     */
    public function getWebCompanyService()
    {
        return $this->hasOne(WebCompanyService::className(), ['id' => 'web_company_service_id']);
    }

    /**
     * {@inheritdoc}
     * @return \frontend\models\company\web\queries\WebCompanyWebCompanyServiceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \frontend\models\company\web\queries\WebCompanyWebCompanyServiceQuery(get_called_class());
    }
}
