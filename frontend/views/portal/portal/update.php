<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\portal\Portal */

$this->title = 'Update Portal: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Порталы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="portal-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
