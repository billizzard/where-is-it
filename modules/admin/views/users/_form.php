<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <? if (!$model->isNewRecord) { ?>

        <h4 style="text-align:center">Смена пароля</h4>

        <?= $form->field($model, 'old_password')->passwordInput(['maxlength' => true])->label('Старый пароль'); ?>

        <?= $form->field($model, 'new_password')->passwordInput(['maxlength' => true])->label('Новый пароль'); ?>

        <?= $form->field($model, 're_password')->passwordInput(['maxlength' => true])->label('Повтор пароля'); ?>

    <? } ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>