<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\company\web\WebCompany */

$this->title = 'Update Web Company: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Web Companies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="web-company-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
