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
