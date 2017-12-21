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
    $verifyImages[] = [$image->url, ['id' => $image->id]];
}
/** @var \app\models\User $user */
$user = Yii::$app->user->getIdentity();

$categories = \app\models\Category::getCategoryStructure();
$select = [];
$disabled = [];
foreach ($categories as $category) {
    $select[$category['id']] = $category['name'];
    if (isset($category['children'])) {
        $disabled[$category['id']] = ['disabled' => 'true'];
        foreach ($category['children'] as $children) {
            $select[$children['id']] = '-' . $children['name'];
            if (isset($children['children'])) {
                $disabled[$children['id']] = ['disabled' => 'true'];
                foreach ($children['children'] as $val) {
                    $select[$val['id']] = '--' . $val['name'];
                }
            }
        }
    }
}

?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group field-place-name required">
    <?= $form->field($model, 'category_ids')->widget(\kartik\select2\Select2::classname(), [
        'data' => $select,
        'options' => ['placeholder' => 'Выберите категории', 'multiple' => true,
            'options' => $disabled],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
//    echo \kartik\select2\Select2::widget([
//        'name' => 'color_2',
//        'value' => ['red', 'green'], // initial value
//        'data' => $select,
//        'showToggleAll' => false,
//        'maintainOrder' => true,
//        'options' => ['placeholder' => 'Выберите категории', 'multiple' => true,
//            'options' => $disabled],
//        'pluginOptions' => [
//            'tags' => true,
//        ],
//    ]);
    ?>
    </div>

    <?= \app\components\widgets\imageUploader\ImageUploaderWidget::widget([
        'config' => [
            'oldImages' => $verifyImages,
            'uploadUrl' => '/admin/places/upload-image/',
            'inputFileName' => "Image[url][]",
            'errorCallback' => 'widgetUploadErrors',
            'maxFiles' => 1,
            'downloadButton' => $user->hasAccess(\app\constants\UserConstants::RULE['DOWNLOAD_IMAGE']) ? true : false
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

    <? if ($user && $user->hasAccess(\app\constants\UserConstants::RULE['OWNER'], ['model' => $model])) {?>
        <?= $form->field($model, 'status')->dropDownList(\app\constants\AppConstants::getStatusMap()) ?>
    <? } ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <? if ($model->parent_id) { ?>
            <input type="hidden" name="copy" value="1">
            <?= Html::submitButton('Скопировать' , ['class' => 'btn btn-primary']) ?>
        <? } ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>