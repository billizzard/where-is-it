<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Place */
/* @var $modelImage app\models\Image */
/* @var $form yii\widgets\ActiveForm */

$categoryMap = \app\models\Category::getCategoriesMap();
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->dropDownList($categoryMap, ['prompt' => 'Выберите категорию']) ?>

    <?= $form->field($modelImage, 'image')->fileInput() ?>


    <div id="ymapAdminPlaceMap" data-lat="<?=$model->lat?>" data-lon="<?=$model->lon?>" style="width:100%; height:320px;"></div>

    <?= $form->field($model, 'lat')->textInput(['class' => 'form-control js-point-lat']) ?>
    <?= $form->field($model, 'lon')->textInput(['class' => 'form-control js-point-lon']) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
    <div class="js-point-address" style="margin-top:-15px; margin-bottom:15px;"></div>
    <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>
    <?= $form->field($model, 'status')->dropDownList(\app\models\Place::getStatusesMap()) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>