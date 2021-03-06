<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <p>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',
            'parent_id',
            'sort',
            [
                'class' => 'app\modules\admin\components\actions\ActionColumn',
                'contentOptions' => ['class' => 'add-info'],
                'template' => '{update_all} {delete} {soft-delete_all}',
            ]
        ],
    ]); ?>
</div>
