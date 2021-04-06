<?php

namespace frontend\models\company\web\queries;

/**
 * This is the ActiveQuery class for [[\frontend\models\company\web\WebCompanyWebCompanyService]].
 *
 * @see \frontend\models\company\web\WebCompanyWebCompanyService
 */
class WebCompanyWebCompanyServiceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \frontend\models\company\web\WebCompanyWebCompanyService[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \frontend\models\company\web\WebCompanyWebCompanyService|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
