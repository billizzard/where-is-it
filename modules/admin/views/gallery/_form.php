<?php

use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Schedule */
/* @var $modelImage app\models\Image */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Галлерея';
$this->params['breadcrumbs'][] = $this->title;
$verifyImages = [];
$user = Yii::$app->user->getIdentity();

if ($images = $model->images) {
    foreach ($images as $image) {
        $verifyImages[] = [
            $image->url,
            [
                'id' => $image->id
            ]
        ];
    }
}
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <?=$form->field($model, 'title')->textInput()?>
    <?= \app\components\widgets\imageUploader\ImageUploaderWidget::widget([
        'config' => [
            'oldImages' => $verifyImages,
            'uploadUrl' => '/admin/gallery/upload-image/',
            'inputFileName' => "Image[url][]",
            'errorCallback' => 'widgetUploadErrors',
            'maxFiles' => 8,
            'downloadButton' => $user->hasAccess(\app\constants\UserConstants::RULE['DOWNLOAD_IMAGE']) ? true : false
        ]
    ]) ?>
    <div class="form-group">
        <?= \yii\helpers\Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

