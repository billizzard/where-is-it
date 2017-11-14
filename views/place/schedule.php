<?php

/* @var $this yii\web\View */
/* @var $schedule \app\models\Schedule */

$this->title = 'My Yii Application';

$formatSchedule = $schedule->getFormatSchedule();
$daysMap = \app\components\Helper::getDaysMap();
?>
<div class="place-schedule place-page">
    <h3>График работы</h3>
    <div class="schedule-container">
    <? if ($formatSchedule) { ?>
    <div>
        <div class="caption">График работы</div>
        <table class="table_col">

            <colgroup>
                <col style="background:#8bb1ec;">
            </colgroup>
            <tr>
                <th>День</th>
                <th>С</th>
                <th>По</th>
            </tr>
            <? for ($i = 1; $i < 8; $i++) { ?>
                <tr>

                    <td><?= $daysMap[$i] ?></td>
                    <? if ($formatSchedule[$i]['hFrom']) {
                        if ($formatSchedule[$i]['hFrom'] == $formatSchedule[$i]['hTo']) {
                            echo '<td colspan="2">Круглосуточно</td>';
                        } else {
                            echo '<td>' . $formatSchedule[$i]['hFrom'] . '</td>';
                            echo '<td>' . $formatSchedule[$i]['hTo'] . '</td>';
                        }
                    } else {
                        echo '<td colspan="2">Выходной</td>';
                    } ?>

                </tr>
            <? } ?>
        </table>
    </div>
    <? } ?>

    <? if ($schedule->add_info) { ?>
        <div class="add_schedule" style="flex-grow:1">
            <div class="caption">Дополнительная информация</div>
            <div class="text"><?= nl2br($schedule->add_info) ?></div>
        </div>
    <? } ?>
    </div>

</div>



