<?php


namespace common\components\behaviors;


use yii\base\Controller;

class ViewParamsBehavior extends \yii\base\Behavior
{
    /**
     * @var array параметры которые предадутся в сайдбар
     */
    public $sideBar = [];
    /**
     * Пример одного элемента
     *  [
     *      'label' => 'Аккаунты',
     *      'url' => \yii\helpers\Url::to(['/portal/account']),
     *      'active' => $this->context->id === 'portal/account',
     *  ],
     *
     * @var array настройки табов на странице,
     */
    public $tabs = [];

    /**
     * @return string[]
     */
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'setViewParams'
        ];
    }

    /**
     *
     */
    public function setViewParams()
    {
        $owner = $this->owner;
        $owner->view->params['sideBar'] = $this->sideBar;
        $owner->view->params['tabs'] = $this->tabs;
    }
}