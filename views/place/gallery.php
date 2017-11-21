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
}?>
<!--<div class="place-gallery place-page">-->
<!--    <h3>Галлерея</h3>-->
<!--    <div class="columns">-->
<!--        --><?// foreach ($columns as $column) {?>
<!--            <div class="column">-->
<!--                --><?// foreach ($column as $url) {?>
<!--                <a class="img-container" data-fancybox="gallery" href="/--><?//=$url['original']?><!--">-->
<!--                    <img src="/--><?//=$url['original']?><!--">-->
<!--                </a>-->
<!--                --><?// } ?>
<!--            </div>-->
<!--        --><?// } ?>
<!--    </div>-->
<!---->
<!--</div>-->
<div class="place-gallery place-page">
    <h3>Галлерея</h3>
    <div class="masonry">
        <? foreach ($columns as $column) {?>
            <? foreach ($column as $url) {?>
<!--            <div class="item" img-container>-->
<!--                <img src="/--><?//=$url['original']?><!--">-->
<!--            </div>-->
                                <a class="item " data-fancybox="gallery" href="/<?=$url['original']?>">
                                    <img src="/<?=$url['original']?>">
                                </a>
                <? } ?>
        <? } ?>
    </div>

</div>
<style>

/*    @media only screen and (min-width: 900px) {
        .masonry {
            -moz-column-count: 4;
            -webkit-column-count: 4;
            column-count: 4;
        }
    }

    @media only screen and (min-width: 1100px) {
        .masonry {
            -moz-column-count: 5;
            -webkit-column-count: 5;
            column-count: 5;
        }
    }*/

</style>

