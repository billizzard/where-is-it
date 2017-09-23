<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;


?>
<div style="display:flex; flex-direction: column; height:100%;">
    <div style="width:100%; flex-basis:50px; flex-grow: 0;">
    </div>
<div id="ymap" style="width:100%; flex-grow:1;"></div>
<div style="width:100%; flex-basis:50px; flex-grow: 0;">
    <form>
        <input type="hidden" name="lat" class="js-point-lon" value="">
        <input type="hidden" name="lon" class="js-point-lat" value="">
        <input type="hidden" name="address" class="js-point-address" value="">
        <input type="hidden" name="category_id" class="js-point-category_id" value="">
        <input type="text" name="name" class="js-point-name" value="" placeholder="Выберите категорию в меню">
        <input type="text" name="category" class="js-point-category" placeholder="Ввдете название" value="">
        <textarea name="description" class="js-point-description" placeholder="Дополнительная информация"></textarea>
        <input type="submit" name="savePoint" class="save-point" value="Save">
    </form>
</div>
</div>
