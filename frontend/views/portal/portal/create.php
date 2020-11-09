<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\portal\Portal */

$this->title = 'Добавить портал';
$this->params['breadcrumbs'][] = ['label' => 'Portals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="portal-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
