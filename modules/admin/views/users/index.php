<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Профиль';
$this->params['breadcrumbs'][] = $this->title;
/** @var \app\models\User $user */
$user = Yii::$app->user->getIdentity();
?>
<div class="user-index">

    <? if ($user->isAdmin()) { ?>
    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <? } ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            'name',
            'email',
            [
                'label' => 'Аватарка',
                'format' => 'raw',
                'value' => function ($model) {
                    return '<a href="/admin/users/avatars/?user_id=' . $model->getId() . '">выбрать аватар</a>';
                }
            ],

            [
                'class' => 'app\modules\admin\components\actions\ActionColumn',
                'contentOptions' => ['class' => 'add-info'],
                //'template' => '{my-stadiums/schedule} {update} {delete}',
                'template' => '{update_all} {delete}',
//                'buttons' => [
//                    'my-stadiums/schedule' => function ($url) {
//                        //return Html::a( '<span class="glyphicon glyphicon-calendar"> </span>', $url, [ 'title' => 'Бронирования', 'data-pjax' => '0', ] );
//                    },
//                ],
            ]
        ],
    ]); ?>
</div>
