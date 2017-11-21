<?php

/* @var $this yii\web\View */
/* @var $reviews \app\models\Review[] */

$this->title = 'My Yii Application';
$typeMap = \app\constants\DiscountConstants::getTypeMap();
?>
<div class="place-contact place-page">
<style>
    .reviews .review {
        display:flex;
        margin-top:20px;
    }
    .review__left {
        padding:5px;
        width:60px;
    }
    .review__right {
        padding:5px;
    }
    .review__name {
        font-size: 16px;
        font-weight: bold;
        color: #656565;
    }
    .review__name span {
        font-size:12px;
        font-style:italic;
        color:#c9ccd0;
    }
    .review__star .glyphicon {
        font-size:18px;
        color:#ffaf02;
    }
</style>
    <h3>Отзывы</h3>
    Всего отзывов: <?=$model->stars_count?> <br>
    Средняя оценка: <?=$model->stars?>
    <div class="reviews">
        <? if ($reviews) {
            foreach ($reviews as $review) {

                ?>

                <div class="review">
                    <div class="review__left">

                    </div>
                    <div class="review__right">
                        <div class="review__name">
                            <?=$review->user ? $review->user->name : ''?>
                            <span><?=$review->getCreatedData()?></span>
                        </div>
                        <div class="review__star">
                        <? for ($i = 1; $i < 6; $i++) {
                            $class = 'glyphicon-star';
                            if ($i > $review->getStar()) {
                                $class = 'glyphicon-star-empty';
                            }
                            ?>
                            <span class="glyphicon <?=$class?>"></span>
                        <? } ?>
                        </div>
                        <div class="review__text">
                            <?=$review->message;?>
                        </div>
                    </div>
                </div>

                <?

            }
        } ?>
    </div>
</div>





