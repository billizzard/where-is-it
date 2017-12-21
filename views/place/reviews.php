<?php

/* @var $this yii\web\View */
/* @var $reviews \app\models\Review[] */

$this->title = 'My Yii Application';
$typeMap = \app\constants\DiscountConstants::getTypeMap();
?>
<div class="place-contact place-page">

    <h3>Отзывы</h3>

    Всего отзывов: <?=$model->stars_count?> <br>
    Средняя оценка: <?=$model->stars?>
    <div class="reviews">
        <? if ($reviews) {
            foreach ($reviews as $review) {

                ?>

                <div class="review">
                    <div class="review__left">
                        <img src="<?=$review->user ? $review->user->getAvatar() : \app\models\User::getDefaultAvatar()?>">
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
                            <?=nl2br($review->message);?>
                        </div>
                    </div>
                </div>

                <?

            }
        } ?>
    </div>
</div>





