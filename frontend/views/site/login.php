<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use common\themes\AdminLTE3\widgets\ActiveForm\ActiveForm;

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

        <?= $form
            ->loginInput($model, 'username')
            // ->textInput(['autofocus' => true])
        ?>

        <?= $form
            ->passwordInput($model, 'password')
        ?>

        <div class="row">
            <div class="col-8">
                <div class="icheck-primary">
                    <?= $form->field($model, 'rememberMe')->checkbox() ?>
                </div>
            </div>

            <div class="col-4">
                <?= Html::submitButton('Вход', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
            </div>

        </div>


        <div style="color:#999;margin:1em 0">
            Если Вы забыли свой пароль, вы можете <?= Html::a('восстановить его', ['site/request-password-reset']) ?>.
            <br>
            Нужно подтвердить учетную записи? <?= Html::a('Выслать подтверждение', ['site/resend-verification-email']) ?>
        </div>



    <?php ActiveForm::end(); ?>


<!--    <form action="../../index3.html" method="post">-->
<!--        <div class="input-group mb-3">-->
<!--            <input type="email" class="form-control" placeholder="Email">-->
<!--            <div class="input-group-append">-->
<!--                <div class="input-group-text">-->
<!--                    <span class="fas fa-envelope"></span>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="input-group mb-3">-->
<!--            <input type="password" class="form-control" placeholder="Password">-->
<!--            <div class="input-group-append">-->
<!--                <div class="input-group-text">-->
<!--                    <span class="fas fa-lock"></span>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="row">-->
<!--            <div class="col-8">-->
<!--                <div class="icheck-primary">-->
<!--                    <input type="checkbox" id="remember">-->
<!--                    <label for="remember">-->
<!--                        Remember Me-->
<!--                    </label>-->
<!--                </div>-->
<!--            </div>-->

<!--            <div class="col-4">-->
<!--                <button type="submit" class="btn btn-primary btn-block">Sign In</button>-->
<!--            </div>-->

<!--        </div>-->
<!--    </form>-->


</div>
