<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\company\web\WebCompany */

$this->title = 'Create Web Company';
$this->params['breadcrumbs'][] = ['label' => 'Web Companies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="web-company-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
