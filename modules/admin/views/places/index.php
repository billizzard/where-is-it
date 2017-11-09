<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$categoriesMap = \app\models\Category::getCategoriesMap();
$statusesMap = \app\constants\AppConstants::getStatusMap();
/** @var \app\models\User $user */
$user = Yii::$app->user->getIdentity();
?>

<? if ($user && $user->hasAccess(\app\models\User::RULE_ADMIN_PANEL)) { ?>
    <?
    $this->title = 'Места';
    $this->params['breadcrumbs'][] = $this->title;
    ?>
<div class="user-index">

    <p>
        <?= Html::a('Создать место', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'filter' => false,
            ],
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
                    return '<a href="/admin/schedules/?place_id=' . $model->id . '" class="glyphicon glyphicon-time"></a> 
<a href="/admin/gallery/?place_id=' . $model->id . '" class="glyphicon glyphicon-camera"></a>
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
<? } else { ?>

    <?
    $this->title = 'Место';
    ?>
    <div class="place-index">

        <p>
            Тут вы можете заполнить информацию о месте более подробно.
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => null,
            'summary' => false,
            'columns' => [
                'name',
                [
                    'attribute' => 'url',
                    'label' => 'Изображение',
                    'format' => 'raw',
                    'value' => function($model) {

                        if ($image = $model->mainImage) {
                            $image = $image->getMainImages();
                            if ($image['map_']) {
                                return '<img src="/' . $image['map_'] . '">';
                            }
                        }
                    }
                ],
                [
                    'label' => 'Добавление информации',
                    'contentOptions' => ['class' => 'add-info'],
                    'format' => 'raw',
                    'value' => function ($model) {
                        return '<a href="/admin/schedules/?place_id=' . $model->id . '" class="glyphicon icon glyphicon-time"></a> - время работы <br> 
<a href="/admin/gallery/?place_id=' . $model->id . '" class="glyphicon icon glyphicon-camera"></a> - галлерея  <br>
<a href="/admin/places/update/?id=' . $model->id . '" class="glyphicon icon glyphicon-pencil"></a> - редактровать объект  <br>
<a href="/admin/discounts/?place_id=' . $model->id . '" class="glyphicon icon glyphicon-c_percent">%</a> - акции и скидки <br> 
<a href="/admin/contacts/?place_id=' . $model->id . '" class="glyphicon icon glyphicon-phone-alt"></a> - контакты <br>  
';
                    }
                ],
                [
                    'attribute' => 'category_id',
                    'value' => function($model) use ($categoriesMap) {
                        return isset($categoriesMap[$model->category_id]) ? $categoriesMap[$model->category_id] : false;
                    }
                ],
                [
                    'attribute' => 'status',
                    'value' => function($model) use ($statusesMap) {
                        return isset($statusesMap[$model->status]) ? $statusesMap[$model->status] : false;
                    }
                ],
            ],
        ]); ?>
    </div>

<? } ?>
