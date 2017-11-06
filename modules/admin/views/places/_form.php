<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Place */
/* @var $modelImage app\models\Image */
/* @var $form yii\widgets\ActiveForm */

$categoryMap = \app\models\Category::getCategoriesMap();
/** @var \app\models\Image $image */
$image = $model->mainImage;
/** @var \app\models\User $user */
$user = Yii::$app->user->getIdentity();
?>
<style>

</style>
<div class="user-form">

    <? if ($noCheckModel) {?>
        <p>
            У места есть непроверенные модератором данные. Данные места временно нельзя изменять/сохранять.
        </p>
    <? } else {  ?>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->dropDownList($categoryMap, ['prompt' => 'Выберите категорию']) ?>

    <? if ($image) { ?>
        <div class="uploaded_img">
            <img src="/<?=$image->getMainImages()['original']?>" alt="">
            <a href="#" class="delete" data-id="<?=$image->getId()?>">x</a>
        </div>
    <? } ?>
    <?= $form->field($modelImage, 'url')->fileInput() ?>


    <div id="ymapAdminPlaceMap" data-lat="<?=$model->lat?>" data-lon="<?=$model->lon?>" style="width:100%; height:320px;"></div>

    <?= $form->field($model, 'lat')->textInput(['class' => 'form-control js-point-lat']) ?>
    <?= $form->field($model, 'lon')->textInput(['class' => 'form-control js-point-lon']) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
    <div class="js-point-address" style="margin-top:-15px; margin-bottom:15px;"></div>
    <?= $form->field($model, 'work_time')->textarea(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

    <? if ($user && $user->isAdmin()) {?>
        <?= $form->field($model, 'yes')->textInput() ?>
        <?= $form->field($model, 'no')->textInput() ?>
    <? } ?>

    <? if ($user && $user->isAdmin()) {?>
        <?= $form->field($model, 'type')->dropDownList(\app\constants\PlaceConstants::getTypeMap()) ?>
    <? } ?>

    <? if ($user && $user->hasAccess(\app\models\User::RULE_OWNER, ['model' => $model])) {?>
        <?= $form->field($model, 'status')->dropDownList(\app\constants\AppConstants::getStatusMap()) ?>
    <? } ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>


    <?php ActiveForm::end(); ?>
    <? } ?>

</div>