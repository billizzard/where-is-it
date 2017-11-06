<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';


$gallery = $model->gallery;


?>
<style>
    .place-gallery {
        display: flex;
        flex-wrap: wrap;
        justify-content: left;
    }
    .place-gallery .img-container {
        overflow: hidden;
        margin:5px;
        border: 3px solid #fff;
        box-shadow: 0 0 10px rgba(0,0,0,0.5);

    }
    .place-gallery .img-container img {
        max-height:265px;
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

    <div class="place-gallery">
        <?
        /** @var \app\models\Image $image */
        foreach ($gallery as $image) {
            $url = $image->getImageSizes();
            ?>
            <a class="img-container" data-fancybox="gallery" href="">
                <img src="/<?=$url['original']?>">
            </a>
        <?
        }?>
    </div>

