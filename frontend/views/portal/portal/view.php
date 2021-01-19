<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\portal\Portal */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Порталы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="portal-view">



    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'url:ntext',
            'description:ntext',
            'status',
            'added_by',
            'date_added',
            [
                'attribute' => 'logoUrl',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::img($model->logoUrl);
                }
            ]
            ,
        ],
    ]) ?>

</div>
