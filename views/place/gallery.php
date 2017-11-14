<?php

/* @var $this yii\web\View */
/* @var $galleries \app\models\Gallery[] */

$this->title = 'My Yii Application';

/** @var \app\models\Image $image */
$i = 0;
$columns = [];
foreach ($galleries as $gallery) {
    $images = $gallery->images;
    if ($images) {
        foreach ($images as $image) {
            $columns[$i][] = $image->getImageSizes();
            $i = $i === 2 ? 0 : $i + 1;
        }
    }
}?>
<div class="place-gallery">

    <div class="columns">
        <? foreach ($columns as $column) {?>
            <div class="column">
                <? foreach ($column as $url) {?>
                <a class="img-container" data-fancybox="gallery" href="/<?=$url['original']?>">
                    <img src="/<?=$url['original']?>">
                </a>
                <? } ?>
            </div>
        <? } ?>
    </div>

</div>

