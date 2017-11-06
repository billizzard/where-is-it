<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$statusesMap = \app\constants\AppConstants::getStatusMap();
/** @var \app\models\User $user */
$user = Yii::$app->user->getIdentity();

$this->title = 'Скидки, акции';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <p>
        <?= Html::a('Добавить акцию, скидку', ['create', 'place_id' => $_GET['place_id']], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'filter' => false,
            ],
            'title',
            'message',
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
