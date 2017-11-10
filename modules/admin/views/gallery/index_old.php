<?php

use app\components\widgets\imageUploader\ImageUploaderWidget;
use \yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Place */
/* @var $modelImage app\models\Image */
/* @var $form yii\widgets\ActiveForm */
$verifyImages = [];
if ($models) {
    foreach ($models as $model) {
        $verifyImages[] = [
            $model->url,
            [
                'id' => $model->id
            ]
        ];
    }
}

$this->title = 'Текущая галерея';
$this->params['breadcrumbs'][] = $this->title;
?>
<? if ($verifyImages) { ?>
    <?php $form = ActiveForm::begin(); ?>
    <?= ImageUploaderWidget::widget([
        'config' => [
            'oldImages' => $verifyImages,
            'uploadUrl' => '/place/upload-image/',
            'deleteUrl' => '/admin/places/remove-image/',
            'inputFileName' => "Image[url][]",
            'errorCallback' => 'galleryErrors',
            'maxFiles' => 5,
            'uploadButton' => false
        ]
    ]) ?>

    <?php ActiveForm::end(); ?>
<? } ?>

<? if ($hasOld && !$verifyImages) { ?>
    Временно нельзя добавлять новые фотографии, так как модератор еще не проверил старые.
<? } else { ?>

    <? if (!$hasNew) { ?>
        <? if ($verifyImages) { ?>
            <section class="content-header" style="margin: 20px 0; border-top:1px solid #ccc;">
                <h1>Вы можете предложить свой вариант галлереи:</h1>
            </section>
        <? } ?>
        <?php $form = ActiveForm::begin(); ?>
        <?= ImageUploaderWidget::widget([
            'config' => [
                'uploadUrl' => '/place/upload-image/',
                'inputFileName' => "Image[url][]",
                'errorCallback' => 'galleryErrors',
                'maxFiles' => 5,
            ]
        ]) ?>
        <div class="form-group">
            <?= \yii\helpers\Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    <? } else { ?>
        <p style="margin-top:10px;">
            Временно нельзя добавить новые фотографии к этому месту. Так как еще есть не проверенные модератором
            фотографии для этого места.
        </p>
    <? } ?>
<? } ?>

<script>
    function galleryErrors(success, message) {
        flashError.setErrors(message);
    }
</script>



