<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Place */
/* @var $modelImage app\models\Image */
/* @var $form yii\widgets\ActiveForm */
$subtitle = '';
if (in_array($type, \app\constants\MessageConstants::getTypeMap())) {
    $subtitle .= 'Тип: ' . \app\constants\MessageConstants::getTypeMap()[$type] . '. ';
}
?>
<div class="page-wrapper">
    <div class="feedback-wrapper">
        <h4>Обратная связть</h4>

            <?php $form = ActiveForm::begin(); ?>
            <?
            if ($place) {
                $subtitle .= 'Место: ' . $place->name . '. ';
                echo $form->field($model, 'place_id')->hiddenInput()->label(false);
            }
            ?>

            <div class="subtitle"><?= $subtitle ?></div>
            <?= $form->field($model, 'type')->hiddenInput(['value' => $type])->label(false) ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'message')->textarea(['style' => 'height:120px;']) ?>
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>

            <?php ActiveForm::end(); ?>

    </div>
</div>