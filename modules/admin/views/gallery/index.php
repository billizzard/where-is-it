<?php

use app\components\widgets\imageUploader\ImageUploaderWidget;
use \yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Place */
/* @var $modelImage app\models\Image */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Галерея';
$this->params['breadcrumbs'][] = $this->title;

?>
<script>
    function galleryErrors (success, message) {
        flashError.setErrors(message);
    }
</script>
<?php $form = ActiveForm::begin(); ?>
<?= ImageUploaderWidget::widget([
    'config' => [
        'uploadUrl' => '/place/upload-image/',
        'inputFileName' => "Image[url][]",
        'errorCallback' => 'galleryErrors'
    ]
])?>
<div class="form-group">
    <?= \yii\helpers\Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>



