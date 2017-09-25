<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\PlaceForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;


?>
<div class="add-place">
    <div class="add-place__header"></div>
    <div class="add-place__map" id="ymapAdd"></div>
    <div id="add-place" class="add-place__footer">
        <?

//
//        echo "<pre>";
//        var_dump($_POST);
//        die();
        ?>
        <form id="form-place" class="form-place" method="post">
            <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
            <input type="hidden" name="Place[lat]" class="js-point-lat required_coord" value="<?= isset($_POST['Place']['lat']) ? $_POST['Place']['lat'] : '' ?>">
            <input type="hidden" name="Place[lon]" class="js-point-lon required_coord" value="<?= isset($_POST['Place']['lon']) ? $_POST['Place']['lon'] : '' ?>">
            <input type="hidden" name="Place[address]" class="js-point-address" value="<?= isset($_POST['Place']['address']) ? $_POST['Place']['address'] : '' ?>">
            <input type="hidden" name="Place[category_id]" class="js-point-category_id required" value="<?= isset($_POST['Place']['category_id']) ? $_POST['Place']['category_id'] : '' ?>">
            <div class="form-place__column">
            <input type="text" name="Place[category]" class="js-point-category required" value="<?= isset($_POST['Place']['category']) ? $_POST['Place']['category'] : '' ?>"
                   placeholder="Выберите категорию в меню"><br>
            <input style="margin-top:5px;" type="text" name="Place[name]" class="js-point-name required" placeholder="Ввдете название" value="<?= isset($_POST['Place']['name']) ? $_POST['Place']['name'] : '' ?>">
            </div>
            <div class="form-place__column">
            <textarea name="Place[description]" class="js-point-description description"
                      placeholder="Дополнительная информация"><?= isset($_POST['Place']['description']) ? $_POST['Place']['description'] : '' ?></textarea>
            <input type="submit" style="vertical-align: top;" name="savePoint" class="save-point btn btn-primary btn-flat" value="Сохранить">
            </div>
        </form>

<!--        --><?php //$form = ActiveForm::begin(['id' => 'form-place', 'enableClientValidation' => false, 'class' => "form-place", 'method' => 'post']); ?>
<!--        --><?//= $form->field($model, 'lat')->label(false)->hiddenInput(['class' => 'js-point-lon required_coord']);?>
<!--        --><?//= $form->field($model, 'lon')->label(false)->hiddenInput(['class' => 'js-point-lat required_coord']);?>
<!--        --><?//= $form->field($model, 'address')->label(false)->hiddenInput(['class' => 'js-point-address']);?>
<!--        --><?//= $form->field($model, 'category_id')->label(false)->hiddenInput(['class' => 'js-point-category_id required']);?>
<!---->
<!--        <div class="form-place__column">-->
<!--        --><?//= $form->field($model, 'category')->label(false)->textInput(['placeholder' => 'Выберите категорию в меню', 'class' => 'js-point-category required']);?>
<!--        --><?//= $form->field($model, 'name')->label(false)->textInput(['placeholder' => 'Ввдете название', 'class' => 'js-point-name required']);?>
<!--        </div>-->
<!--        <div class="form-place__column">-->
<!--        --><?//= $form->field($model, 'description')->label(false)->textarea(['placeholder' => 'Дополнительная информация', 'class' => 'js-point-description description']);?>
<!--        --><?//= Html::submitButton('Сохранить', ['class' => 'btn btn-primary btn-block btn-flat ', 'name' => 'savePoint']) ?>
<!--        </div>-->
<!--        --><?php //ActiveForm::end(); ?>

    </div>
</div>

<style>
    .add-place {
        display:flex;
        flex-direction: column;
        height:100%;
    }
    .add-place__header {
        width:100%;
        flex-basis:50px;
        flex-grow: 0;
    }
    .add-place__map {
        width:100%;
        flex-grow:1;
        min-height:200px;
    }
    .add-place__footer {
        width:100%;
        flex-basis:100px;
        flex-grow: 0;
    }
    .form-place {
        display:flex;
        flex-wrap: wrap;
        justify-content: left;
    }
    .form-place .description {
        height:45px;
    }

    .form-place .form-place__column {
        padding:10px 0 0 10px;
    }

    .form-place .form-place__column input[type=text] {
        width:250px;
        height:26px;
    }

    .form-place .form-place__column textarea {
        height: 57px;
        width:300px;
    }

</style>
