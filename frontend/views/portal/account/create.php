<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\portal\Account */

$this->title = 'Добавление аккаунта';
$this->params['breadcrumbs'][] = ['label' => 'Аккаунты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="account-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
