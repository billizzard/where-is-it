<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$statusesMap = \app\constants\AppConstants::getStatusMap();
/** @var \app\models\User $user */
$user = Yii::$app->user->getIdentity();

$this->title = 'График работы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <p>
        <?= Html::a('Создать график работы', ['create', 'place_id' => $_GET['place_id']], ['class' => 'btn btn-success']) ?>
    </p>
    <p>
        Здесь вы можете создать/изменить график работы для этого места.
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'filter' => false,
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
