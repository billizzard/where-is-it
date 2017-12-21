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
            $i = $i === 3 ? 0 : $i + 1;
        }
    }
} ?>

<div class="place-gallery place-page">
    <h3>Галлерея</h3>
    <div class="masonry">
        <? foreach ($columns as $column) { ?>
            <? foreach ($column as $url) { ?>

                <a class="item " data-fancybox="gallery" href="/<?= $url['original'] ?>">
                    <img src="/<?= $url['original'] ?>">
                </a>
            <? } ?>
        <? } ?>
    </div>

</div>


