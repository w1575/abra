<?php

namespace frontend\models\portal\queries;

use frontend\components\query\CommomActiveQuery;

/**
 * This is the ActiveQuery class for [[Account]].
 *
 * @see Account
 */
class AccountQuery extends CommomActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Account[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Account|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
