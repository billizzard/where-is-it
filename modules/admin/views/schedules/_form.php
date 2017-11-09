<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Place */
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

    <?php $form = ActiveForm::begin(['options' => ['style' => 'overflow: auto;']]); ?>

    <table class="schedule__table js-schedule">
        <tr>
            <th colspan="3">График</th>
            <th>Круг-но</th>
            <th>Вых.</th>
        </tr>
    <?php foreach ($days as $key => $day) { ?>
        <tr>
            <td><?= $day ?>:</td>
            <td class="js-visible time-container">
                &nbsp; c &nbsp;
                <div class="schedule__time">
                    <select id="place-type" class="form-control" name="<?=$key?>_from_h" aria-invalid="false">
                        <option value="-1" selected> - </option>
                        <? foreach ($hours as $hKey => $hour) { ?>
                            <option value="<?=$hKey?>"
                                <?=isset($format[$key]['hFrom']) && $format[$key]['hFrom'] == $hour ? 'selected' : ''?>
                            ><?=$hour?></option>
                            
                        <? } ?>
                    </select>
                </div>
                <div class="schedule__time">
                    <select id="place-type" class="form-control" name="<?=$key?>_from_m" aria-invalid="false">
                        <option value="-1" selected> - </option>
                        <? foreach ($minutes as $mKey => $min) { ?>
                            <option value="<?=$mKey?>"
                                <?=isset($format[$key]['mFrom']) && $format[$key]['mFrom'] == $min ? 'selected' : ''?>
                            ><?=$min?></option>
                        <? } ?>
                    </select>
                </div>
            </td>

            <td class="js-visible time-container">
                &nbsp; по &nbsp;

                <div class="schedule__time">
                    <select id="place-type" class="form-control" name="<?=$key?>_to_h" aria-invalid="false">
                        <option value="-1" selected> - </option>
                        <? foreach ($hours as $mKey => $hour) { ?>
                            <option value="<?=$mKey?>"
                                <?=isset($format[$key]['hTo']) && $format[$key]['hTo'] == $hour ? 'selected' : ''?>
                            ><?=$hour?></option>
                        <? } ?>
                    </select>
                </div>

                <div class="schedule__time">
                    <select id="place-type" class="form-control" name="<?=$key?>_to_m" aria-invalid="false">
                        <option value="-1" selected> - </option>
                        <? foreach ($minutes as $mKey => $min) { ?>
                            <option value="<?=$mKey?>"
                                <?=isset($format[$key]['mTo']) && $format[$key]['mTo'] == $min ? 'selected' : ''?>
                            ><?=$min?></option>
                        <? } ?>
                    </select>
                </div>
            </td>
            <td class="js-visible"><input type="checkbox" name="<?=$key?>_all" class="form-input" value="1"> </td>
            <td><input type="checkbox" name="<?=$key?>_output" class="form-input js-output" value="1" <?= !isset($format[$key]['hTo']) || $format[$key]['hTo'] === null ? 'checked' : '' ?>> </td>
        </tr>

    <? } ?>
    </table>

    <div class="form-group" style="margin-top:15px;">
        <?= Html::submitButton('Сохранить', ['class' =>'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

