<?php


namespace common\themes\AdminLTE3\widgets\ActiveForm;


use yii\db\ActiveRecord;
use yii\widgets\ActiveForm as BaseForm;

class ActiveForm extends BaseForm
{
    /**
     * Инициализация
     */
    public function init()
    {
        $this->errorCssClass = 'error';
        parent::init();
    }

    /**
     * @param $model ActiveRecord
     * @param $attribute
     */
    public function loginInput($model, $attribute)
    {
        $fieldsOptions = [];
        $fieldsOptions['template'] = $this->render('login-input');
        $fieldsOptions['options']['class'] = 'input-group mb-3 login-input-wrap';
//        $fieldsOptions['errorCssClass'] = 'error';
        return
            $this
                ->field($model, $attribute, $fieldsOptions)
                ->textInput(
                    [
                        'class' => 'form-control',
                        'placeholder' => $model->getAttributeLabel($attribute)
                    ]
                );
    }

    /**
     * @param $model ActiveRecord
     * @param $attribute
     * @return \yii\widgets\ActiveField
     */
    public function passwordInput($model, $attribute)
    {
        $fieldsOptions = [];
        $fieldsOptions['template'] = $this->render('password-input');
        $fieldsOptions['options']['class'] = 'input-group mb-3 login-input-wrap';
        return
            $this
                ->field($model, $attribute, $fieldsOptions)
                ->passwordInput(
                    [
                        'class' => 'form-control',
                        'placeholder' => $model->getAttributeLabel($attribute)
                    ]
                );
    }

    /**
     * @param $model ActiveRecord
     * @param $attribute
     * @return \yii\widgets\ActiveField
     */
    public function checkBoxInput($model, $attribute)
    {
        $fieldsOptions = [];
        $fieldsOptions['template'] = $this->render('checkbox-input');

        return $this
            ->field($model, $attribute, $fieldsOptions)
            ->checkbox();

    }
}