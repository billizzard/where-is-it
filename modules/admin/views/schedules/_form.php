<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Schedule */
/* @var $modelImage app\models\Image */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'График работы';
$this->params['breadcrumbs'][] = $this->title;
$days = \app\components\Helper::getDaysMap();
$hours = \app\components\Helper::getHoursMap();
$minutes = \app\components\Helper::getMinutesMap();
$format = $model->getFormatSchedule();

?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['style' => 'overflow: auto; padding-bottom: 50px;']]); ?>

    <table class="schedule__table js-schedule">
        <tr>
            <th colspan="3">График (c/по)</th>
            <th>Круг-но</th>
            <th>Вых.</th>
        </tr>
    <?php foreach ($days as $key => $day) { ?>
        <tr>
            <td><?= $day ?>:</td>
            <td class="js-visible time-container">
                <div class="schedule__time">
                    <?= \kartik\time\TimePicker::widget(['name' => $key . '_from_h', 'pluginOptions' => [
                        'showMeridian' => false,
                        'minuteStep' => 5,
                        'defaultTime' => $format[$key]['hFrom'] ? $format[$key]['hFrom'] : '00:00'
                    ]]);?>
                </div>
            </td>

            <td class="js-visible time-container">

                <div class="schedule__time">
                    <?= \kartik\time\TimePicker::widget(['name' => $key . '_to_h', 'pluginOptions' => [
                        'showMeridian' => false,
                        'minuteStep' => 5,
                        'defaultTime' => $format[$key]['hTo'] ? $format[$key]['hTo'] : '00:00'
                    ]]);?>
                </div>
            </td>
            <?
            $allChecked = '';
            if ($format[$key]['hTo'] == $format[$key]['hFrom'] && $format[$key]['hFrom'] != null) {
                $allChecked = 'checked';
            }
            ?>
            <td class="js-visible"><input type="checkbox" name="<?=$key?>_all" <?=$allChecked?> class="form-input" value="1"> </td>
            <td><input type="checkbox" name="<?=$key?>_output" class="form-input js-output" value="1" <?= !isset($format[$key]['hTo']) || $format[$key]['hTo'] === null ? 'checked' : '' ?>> </td>
        </tr>

    <? } ?>
    </table>

    <?=$form->field($model, 'add_info')->textarea()?>

    <div class="form-group" style="margin-top:15px;">
        <?= Html::submitButton('Сохранить', ['class' =>'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

