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

$verifyImages = [];
if ($image) {
    $verifyImages[] = [$image->url];
}
/** @var \app\models\User $user */
$user = Yii::$app->user->getIdentity();
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->dropDownList($categoryMap, ['prompt' => 'Выберите категорию']) ?>

    <?= \app\components\widgets\imageUploader\ImageUploaderWidget::widget([
        'config' => [
            'oldImages' => $verifyImages,
            'uploadUrl' => '/admin/places/upload-image/',
            'inputFileName' => "Image[url][]",
            'errorCallback' => 'widgetUploadErrors',
            'maxFiles' => 1,
        ]
    ]) ?>

    <div id="ymapAdminPlaceMap" data-lat="<?=$model->lat?>" data-lon="<?=$model->lon?>" style="width:100%; height:320px;"></div>

    <?= $form->field($model, 'lat')->textInput(['class' => 'form-control js-point-lat']) ?>
    <?= $form->field($model, 'lon')->textInput(['class' => 'form-control js-point-lon']) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
    <div class="js-point-address" style="margin-top:-15px;">&nbsp;</div>
    <?= $form->field($model, 'prev_description')->textarea(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

    <? if ($user && $user->isAdmin()) {?>
        <?= $form->field($model, 'yes')->textInput() ?>
        <?= $form->field($model, 'no')->textInput() ?>
        <?= $form->field($model, 'type')->dropDownList(\app\constants\PlaceConstants::getTypeMap()) ?>
    <? } ?>

    <? if ($user && $user->hasAccess(\app\models\User::RULE_OWNER, ['model' => $model])) {?>
        <?= $form->field($model, 'status')->dropDownList(\app\constants\AppConstants::getStatusMap()) ?>
    <? } ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>