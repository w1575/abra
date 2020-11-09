<?php


namespace frontend\components\behaviors;

use yii\db\ActiveRecord;

class CommonModelBehavior extends \yii\base\Behavior
{
    /**
     * Статус "удаленной" записи.
     */
    public const STATUS_DELETED = -1;
    /**
     * Статаус активной записи.
     */
    public const STATUS_ACTIVE = 1;
    /**
     * Статус не активной записи.
     */
    public const STATUS_INACTIVE = 0;

    /**
     * @return array|string[]
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'doThingsBeforeInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'doThingsBeforeUpdate',
        ];
    }

    /**
     * @return mixed
     */
    public function delete()
    {
        $this->owner->status = static::STATUS_DELETED;
        return $this
            ->owner
            ->save()
            ;
    }

    /**
     * Возвращает отформатированную дату добалвения записи для пользовател.
     * @return string|null
     */
    public function getUserFriendlyDateAdded()
    {
        return $this->owner->date_added === null
            ? null
            : (new \DateTime())->format('d.m.Y h:i')
            ;
    }

    /**
     * @return bool
     */
    public function doThingsBeforeInsert()
    {
        $this->setDateAdded();
        $this->setAddedBy();
        return true;
    }

    /**
     * @return bool
     */
    public function doThingsBeforeUpdate()
    {
        return true;
    }

    /**
     * @return mixed|string
     */
    private function getTimeZone()
    {
        return \yii::$app->params['timeZone'] ?? 'Europe/Moscow';
    }

    /**
     * @throws \Exception
     */
    private function setDateAdded()
    {
        $date = (new \DateTime(
            'now',
            new \DateTimeZone($this->getTimeZone())
        )
        )->format('d.m.Y h:i');
        $this->owner->date_added = $date;
    }

    /**
     * Устанавливает создателя записи
     */
    private function setAddedBy()
    {
        $this->owner->added_by = \yii::$app->user->id;
    }
}