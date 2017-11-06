<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Place */
/* @var $modelImage app\models\Image */
/* @var $form yii\widgets\ActiveForm */
$subtitle = '';
?>
<div class="page-wrapper">
    <div class="feedback-wrapper">
        <h4>Отзыв</h4>

        <?php $form = ActiveForm::begin(); ?>
        <?
        if ($place) {
            $subtitle .= 'Место: ' . $place->name . '. ';
            echo $form->field($model, 'place_id')->hiddenInput()->label(false);
        }
        ?>
        <?=$form->field($model, 'star')->hiddenInput(['id' => 'star'])->label(false);?>
        <div class="subtitle"><?= $subtitle ?></div>
        <div class="form-group field-review-message">
            <label class="control-label" for="review-message">Оценка: </label>
            <div class="r-star-group">
                <? for ($i = 1; $i < 6; $i++) {?>
                <a target="_blank" href="#" class="glyphicon star js-r-star  glyphicon-star<?=$model->star >= $i ? '' : '-empty' ?>" title="Оценка <?=$i?>"></a>
                <? } ?>
            </div>
        </div>
        <?= $form->field($model, 'message')->textarea(['style' => 'height:120px;']) ?>
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
        <?php ActiveForm::end(); ?>

    </div>
</div>