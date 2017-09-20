<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',
            'email',

            [
                'class' => 'yii\grid\ActionColumn',
                //'template' => '{my-stadiums/schedule} {update} {delete}',
                'template' => '{update} {delete}',
//                'buttons' => [
//                    'my-stadiums/schedule' => function ($url) {
//                        //return Html::a( '<span class="glyphicon glyphicon-calendar"> </span>', $url, [ 'title' => 'Бронирования', 'data-pjax' => '0', ] );
//                    },
//                ],
            ]
        ],
    ]); ?>
</div>
