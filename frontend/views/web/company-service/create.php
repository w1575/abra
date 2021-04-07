<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\company\web\WebCompanyService */

$this->title = 'Create Web Company Service';
$this->params['breadcrumbs'][] = ['label' => 'Web Company Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="web-company-service-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
