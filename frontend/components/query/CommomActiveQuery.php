<?php


namespace frontend\components\query;


use frontend\components\behaviors\CommonModelBehavior;

class CommomActiveQuery extends \yii\db\ActiveQuery
{
    /**
     * Не удален
     * @return CommomActiveQuery
     */
    public function notDeleted()
    {
        return $this->andWhere(
            [
                '<>',
                'status',
                CommonModelBehavior::STATUS_DELETED,
            ]
        );
    }


}