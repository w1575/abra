<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\portal\Portal */

$this->title = 'Update Portal: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Portals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="portal-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
