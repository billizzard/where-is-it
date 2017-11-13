<?php

/* @var $this yii\web\View */
/* @var $galleries \app\models\Gallery[] */

$this->title = 'My Yii Application';

?>
<style>

    .place-gallery .img-container {
        overflow: hidden;
        margin:5px;
        border: 3px solid #fff;
        box-shadow: 0 0 10px rgba(0,0,0,0.5);

    }
    .place-gallery .img-container img {
        -webkit-transform: scale(1);
        transform: scale(1);
        -webkit-transition: 1.2s ease-in-out;
        transition: 1.2s ease-in-out;
    }
    .place-gallery .img-container:hover img {
        -webkit-transform: scale(1.2);
        transform: scale(1.2);
    }
</style>
<?
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
<style>
    /* Create four equal columns that floats next to each other */
    .column {
        float: left;
        width: 33%;
        padding: 3px;
    }

    .column a {
        display:block;
        margin-top: 12px;
    }

    .column a img {
        width:100%;
    }

    /* Clear floats after the columns */
    .columns:after {
        content: "";
        display: table;
        clear: both;
    }

    /* Responsive layout - makes a two column-layout instead of four columns */
    @media (max-width: 800px) {
        .column {
            width: 50%;
        }
    }

    /* Responsive layout - makes the two columns stack on top of each other instead of next to each other */
    @media (max-width: 600px) {
        .column {
            width: 100%;
        }
    }
</style>

