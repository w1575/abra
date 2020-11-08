<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $verification_token
 *
 * @property Portal[] $portals
 * @property PortalAccount[] $portalAccounts
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'verification_token' => 'Verification Token',
        ];
    }

    /**
     * Gets query for [[Portals]].
     *
     * @return \yii\db\ActiveQuery|\frontend\models\queries\PortalQuery
     */
    public function getPortals()
    {
        return $this->hasMany(Portal::className(), ['added_by' => 'id']);
    }

    /**
     * Gets query for [[PortalAccounts]].
     *
     * @return \yii\db\ActiveQuery|\frontend\models\queries\PortalAccountQuery
     */
    public function getPortalAccounts()
    {
        return $this->hasMany(PortalAccount::className(), ['added_by' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \frontend\models\queries\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \frontend\models\queries\UserQuery(get_called_class());
    }
}
