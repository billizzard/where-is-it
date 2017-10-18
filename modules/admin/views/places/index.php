<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Места';
$this->params['breadcrumbs'][] = $this->title;
$categoriesMap = \app\models\Category::getCategoriesMap();
$statusesMap = \app\constants\AppConstants::getStatusMap();

?>
<style>
    .grid-view .table > tbody > tr > td.add-info {
        padding:0;
    }
    .grid-view .add-info .glyphicon {
        display: inline-block;
        background-color: #ffffff;
        padding: 7px;
        color:#bfbfbf;
        color: #636363;
        font-size: 18px;
        border-radius: 3px;
        border: 1px solid #e5efff;
        cursor: pointer;
    }

    .grid-view .add-info .glyphicon:hover{
        background-color:#cecece;
    }

    .grid-view .add-info .glyphicon:active{
        background-color:#969696;
    }

</style>
<div class="user-index">

    <p>
        <?= Html::a('Создать место', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',
            [
                'attribute' => 'category_id',
                'filter'=> $categoriesMap,
                'value' => function($model) use ($categoriesMap) {
                    return isset($categoriesMap[$model->category_id]) ? $categoriesMap[$model->category_id] : false;
                }
            ],
            [
                'label' => 'Добавление информации',
                'contentOptions' => ['class' => 'add-info'],
                'format' => 'raw',
                'filter' => "серый - не заполено <br> черный - заполнено",
                'value' => function ($model) {
                    return '<div class="glyphicon glyphicon-time"></div> 
<div class="glyphicon glyphicon-time"></div>
<div class="glyphicon glyphicon-time"></div>';
                }
            ],
            [
                'attribute' => 'status',
                'filter'=> $statusesMap,
                'value' => function($model) use ($statusesMap) {
                    return isset($statusesMap[$model->status]) ? $statusesMap[$model->status] : false;
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ]
        ],
    ]); ?>
</div>
