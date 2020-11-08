<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">



            <?php $form = ActiveForm::begin(
                    [
                            'id' => 'login-form',
//                            'layout' => 'inline',
                    ]
            );?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div style="color:#999;margin:1em 0">
                    Если Вы забыли свой пароль, вы можете <?= Html::a('восстановить его', ['site/request-password-reset']) ?>.
                    <br>
                    Нужно подтвердить учетную записи? <?= Html::a('Выслать подтверждение', ['site/resend-verification-email']) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Вход', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>


</div>
