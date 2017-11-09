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

        <form id="form-place" class="form-place" method="post">
            <input type="hidden" id="csrf" name="<?= Yii::$app->request->csrfParam; ?>"
                   value="<?= Yii::$app->request->csrfToken; ?>"/>
            <input type="hidden" id="image-hid" name="image" value=""/>
            <input type="hidden" name="Place[lat]" class="js-point-lat required_coord"
                   value="<?= isset($_POST['Place']['lat']) ? $_POST['Place']['lat'] : '' ?>">
            <input type="hidden" name="Place[lon]" class="js-point-lon required_coord"
                   value="<?= isset($_POST['Place']['lon']) ? $_POST['Place']['lon'] : '' ?>">
            <input type="hidden" name="Place[address]" class="js-point-address"
                   value="<?= isset($_POST['Place']['address']) ? $_POST['Place']['address'] : '' ?>">
            <input type="hidden" name="Place[category_id]" class="js-point-category_id required"
                   value="<?= isset($_POST['Place']['category_id']) ? $_POST['Place']['category_id'] : '' ?>">

            <div class="form-place__column">
                <input type="text" name="Place[category]" class="js-point-category required" disabled
                       value="<?= isset($_POST['Place']['category']) ? $_POST['Place']['category'] : '' ?>"
                       placeholder="*Выберите категорию в меню"><br>
                <input style="margin-top:5px;" type="text" name="Place[name]" class="js-point-name required"
                       placeholder="*Ввдете название"
                       value="<?= isset($_POST['Place']['name']) ? $_POST['Place']['name'] : '' ?>">
            </div>

<!--            <div class="form-place__column">
                <textarea name="Place[work_time]" placeholder="Время работы и подобная информация"><?/*= isset($_POST['Place']['work_time']) ? $_POST['Place']['work_time'] : '' */?></textarea>
            </div>-->

            <div class="form-place__column">
                <textarea name="Place[description]" placeholder="Полезная информация"><?= isset($_POST['Place']['description']) ? $_POST['Place']['description'] : '' ?></textarea>
                <input type="file" name="Image[url]" id="image" accept="image/*" class="js-image" style="display:none;">
                <div class="fake-image js-fake-image">
                    <span class="glyphicon glyphicon-camera camera-icon"></span>
                    <div class="remove-icon" style="display:none">удалить</div>
                </div>
                <button type="submit" style="vertical-align: top;" name="savePoint"  class="save-point btn btn-primary btn-flat">Сохранить</button>
            </div>

        </form>

    </div>
</div>

<style>
    .add-place {
        display: flex;
        flex-direction: column;
        height: 100%;
        background-color: #2d2d2d;
    }

    .add-place__header {
        width: 100%;
        flex-basis: 45px;
        flex-grow: 0;
    }

    .add-place__map {
        width: 100%;
        flex-grow: 1;
        min-height: 250px;
    }

    .add-place__footer {
        width: 100%;
        flex-basis: 77px;
        flex-grow: 0;
    }

    .form-place {
        display: flex;
        flex-wrap: wrap;
        justify-content: left;
    }

    .form-place input, .form-place textarea {
        border: 2px solid #7b7b7b;
        border-radius: 5px;
        padding: 0 5px;
    }

    .form-place textarea {
        height: 45px;
    }

    .form-place .btn-primary {
        border: 1px solid #7b7b7b;
        height: 57px;
        background-color: transparent;
    }

    .form-place .form-place__column {
        padding: 10px 0 0 10px;
    }

    .fake-image {
        display: inline-block;
        border: 1px solid #7d7d7d;
        border-radius: 5px;
        width: 57px;
        height: 57px;
        cursor: pointer;
        position:relative;
        color:#9d9d9d;
        background-size:cover;
    }

    .fake-image:hover {
        color:#fff;
    }

    .fake-image:active {
        background-color: #101010;
    }

    .fake-image .camera-icon {
        color:inherit;
        position: absolute;
        font-size: 30px;
        top: 11px;
        left: 12px;
    }

    .fake-image .remove-icon {
        position: absolute;
        bottom: 0;
        width: 100%;
        font-size: 12px;
        text-align: center;
        background-color: rgba(157, 157, 157, 0.7);
        color: #f7f7f7;
        cursor: pointer;
    }

    .fake-image .remove-icon:hover {
        background-color: rgba(56, 56, 56, 0.7);
    }

    .form-place .form-place__column input[type=text] {
        width: 300px;
        height: 26px;
    }

    .form-place .form-place__column textarea {
        height: 57px;
        width: 300px;
    }

    .form-place .btn-primary:active:focus {
        background-color: #101010;
    }

</style>
