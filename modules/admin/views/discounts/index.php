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

$this->title = 'Скидки, акции';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <? if ($isCanAdd) { ?>
        <p>
            <?= Html::a('Добавить акцию, скидку', ['create', 'place_id' => $_GET['place_id']], ['class' => 'btn btn-success']) ?>
        </p>
    <? } ?>
    <p>
        Здесь вы можете управлять акциями и скидками для этого места.
        <? if (!$isCanAdd) { ?>
            Временно нельзя создавать/изменять скидки и акции, так как уже есть 5 не проверенных модератором новых записей
        <? } ?>
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
                'class' => 'app\modules\admin\components\actions\ActionColumn',
                'template' => '{update_all} {soft-delete_all}',
                'contentOptions' => ['class' => 'add-info']
            ]
        ],
    ]); ?>
</div>
