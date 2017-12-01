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
$this->title = 'Места';
$this->params['breadcrumbs'][] = $this->title;
?>



    <?
    $this->title = 'Место';
    ?>
    <div class="place-index">
        <? if ($user && $user->isAdmin()) { ?>
        <p>
            <?= Html::a('Создать место', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <? } ?>

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
//                [
//                    'attribute' => 'category_id',
//                    'value' => function($model) use ($categoriesMap) {
//                        return isset($categoriesMap[$model->category_id]) ? $categoriesMap[$model->category_id] : false;
//                    }
//                ],
                [
                    'attribute' => 'status',
                    'value' => function($model) use ($statusesMap) {
                        return isset($statusesMap[$model->status]) ? $statusesMap[$model->status] : false;
                    }
                ],
                [
                    'class' => 'app\modules\admin\components\actions\ActionColumn',
                    'contentOptions' => ['class' => 'add-info'],
                    'template' => '{soft-delete_all} {delete}',
                ]
            ],
        ]); ?>
    </div>

