<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
$url = [];

?>
<? if ($model->getDescription()) {?>
    <div class="info">
        <?=$model->getDescription()?>
    </div>
<? } ?>

<? if ($model->lat) {?>
    <div id="placeMap" data-lat="<?=$model->lat?>" data-lon="<?=$model->lon?>" style="width:100%; height:300px; margin: 5px 0;"></div>
<? } ?>
