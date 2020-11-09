<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\portal\search\Portal */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Порталы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="portal-index">



    <p>
        <?= Html::a('Добавить портал', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'url:ntext',
            'description:ntext',
            'status',
            //'added_by',
            //'date_added',
            //'logo_path',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
