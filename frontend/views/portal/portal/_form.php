<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\portal\Portal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="portal-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'added_by')->textInput() ?>

    <?= $form->field($model, 'date_added')->textInput() ?>

    <?= $form->field($model, 'logo_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'logoFile')->fileInput() ?>

    <?php $imgUrl = $model->getImageUrl('logoFile') ?>
    <?php if ($imgUrl !== null): ?>
    <?= Html::img($imgUrl) ?>
    <?php endif; ?>
    <?= $form
            ->field($model, 'deleteLogo')
            ->checkbox()
            ->hint("Если Вы загружаете новый логотип, то старый будет удален автоматически.")
    ?>
    <?php // endif;?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
