<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $isCanAdd boolean */
$statusesMap = \app\constants\AppConstants::getStatusMap();
/** @var \app\models\User $user */
$user = Yii::$app->user->getIdentity();

$this->title = 'Галлереи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <? if ($isCanAdd) { ?>
    <p>
        <?= Html::a('Создать галлерею', ['create', 'place_id' => $_GET['place_id']], ['class' => 'btn btn-success']) ?>
    </p>
    <? } ?>
    <p>
        Здесь вы можете создать/изменить галлерею фотографий для этого места.
        <? if (!$isCanAdd) { ?>
        Временно нельзя создавать/изменять галлереи, так как уже есть 5 не проверенных модератором новых галлерей
        <? } ?>
    </p>

    <? if ($dataProvider->getTotalCount()) { ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'title',
            [
                'attribute' => 'status',
                'value' => function($model) use ($statusesMap) {
                    return isset($statusesMap[$model->status]) ? $statusesMap[$model->status] : false;
                }
            ],
            [
                'class' => 'app\modules\admin\components\actions\ActionColumn',
                'template' => '{update_all} {soft-delete_all} {delete}',
                'contentOptions' => ['class' => 'add-info']
            ]
        ],
    ]); ?>
    <? } ?>
</div>
