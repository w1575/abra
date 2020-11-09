<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\portal\Account */

$this->title = 'Редактирование аккаунта: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="account-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
