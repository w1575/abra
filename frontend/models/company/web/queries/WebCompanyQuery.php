<?php

namespace frontend\models\company\web\queries;

/**
 * This is the ActiveQuery class for [[\frontend\models\company\web\WebCompany]].
 *
 * @see \frontend\models\company\web\WebCompany
 */
class WebCompanyQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \frontend\models\company\web\WebCompany[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \frontend\models\company\web\WebCompany|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
