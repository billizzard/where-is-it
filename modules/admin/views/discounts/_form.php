<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Place */
/* @var $modelImage app\models\Image */
/* @var $form yii\widgets\ActiveForm */

/** @var \app\models\Image $image */
$image = $model->mainImage;
$verifyImage = [];
if ($image) {
    $verifyImage[] = [$image->url];
}
/** @var \app\models\User $user */
$user = Yii::$app->user->getIdentity();
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= \app\components\widgets\imageUploader\ImageUploaderWidget::widget([
        'config' => [
            'oldImages' => $verifyImage,
            'uploadUrl' => '/admin/discounts/upload-image/',
            'inputFileName' => "Image[url][]",
            'errorCallback' => 'widgetUploadErrors',
        ]
    ]) ?>

    <?= $form->field($model, 'message')->textarea() ?>
    <?= $form->field($model, 'start_date')->textInput() ?>
    <?= $form->field($model, 'end_date')->textInput() ?>

    <?= $form->field($model, 'type')->dropDownList(\app\constants\DiscountConstants::getTypeMap()) ?>

    <? if ($user && $user->hasAccess(\app\models\User::RULE_OWNER, ['model' => $model])) {?>
        <?= $form->field($model, 'status')->dropDownList(\app\constants\AppConstants::getStatusMap()) ?>
    <? } ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>


    <?php ActiveForm::end(); ?>


</div>