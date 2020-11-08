<?php

namespace frontend\models\queries;

/**
 * This is the ActiveQuery class for [[\frontend\models\User]].
 *
 * @see \frontend\models\User
 */
class UserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \frontend\models\User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \frontend\models\User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
