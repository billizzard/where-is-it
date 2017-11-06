<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Place */
/* @var $modelImage app\models\Image */
/* @var $form yii\widgets\ActiveForm */

/** @var \app\models\Image $image */
$image = $model->mainImage;
/** @var \app\models\User $user */
$user = Yii::$app->user->getIdentity();
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <? if (isset($image)) { ?>
        <div class="uploaded_img">
            <img src="/<?=$image->getMainImages()['original']?>" alt="">
            <a href="#" class="delete" data-id="<?=$image->getId()?>">x</a>
        </div>
    <? } ?>
    <?= $form->field($modelImage, 'url')->fileInput() ?>

    <?= $form->field($model, 'message')->textarea() ?>
    <?= $form->field($model, 'start_date')->textInput() ?>
    <?= $form->field($model, 'end_date')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList(\app\constants\AppConstants::getStatusMap()) ?>
    <?= $form->field($model, 'type')->dropDownList(\app\constants\DiscountConstants::getTypeMap()) ?>


<!--    <?/* if ($user && $user->hasAccess(\app\models\User::RULE_OWNER)) {*/?>
        <?/*= $form->field($model, 'status')->dropDownList(\app\constants\AppConstants::getStatusMap()) */?>
    --><?/* } */?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>


    <?php ActiveForm::end(); ?>


</div>