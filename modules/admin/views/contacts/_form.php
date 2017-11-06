<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Place */
/* @var $modelImage app\models\Image */
/* @var $form yii\widgets\ActiveForm */

/** @var \app\models\Image $image */
/** @var \app\models\User $user */
$user = Yii::$app->user->getIdentity();
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'phone')->textarea() ?>

    <?= $form->field($model, 'email')->textarea() ?>

    <?= $form->field($model, 'status')->dropDownList(\app\constants\AppConstants::getStatusMap()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>


    <?php ActiveForm::end(); ?>


</div>