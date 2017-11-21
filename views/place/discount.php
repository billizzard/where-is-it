<?php

/* @var $this yii\web\View */
/* @var $discounts \app\models\Discount[] */

$this->title = 'My Yii Application';
$typeMap = \app\constants\DiscountConstants::getTypeMap();
?>
<div class="place-contact place-page">

    <h3>Акции, скидки</h3>
    <div class="discounts-container">
        <? if ($discounts) {
            foreach ($discounts as $discount) { ?>

                <div class="discount-container">
                    <div class="caption"><?= $discount->title ?>
                    </div>
                    <div class="discount">
                        <?
                        /** @var \app\models\Image $image */
                        if ($image = $discount->mainImage) {
                            $sizes = $image->getImageSizes();
                            ?>
                            <div class="discount__img">
                                <img src="/<?=$sizes['original'] ?>">
                            </div>
                        <? } ?>
                        <div class="discount__info">

                            <? if ($discount->title) { ?>

                            <? } ?>
                            <div class="message">
                                <?= nl2br($discount->message) ?>
                            </div>
                        </div>
                    </div>
                    <div class="discount__footer">
                        Дата начала: <?= $discount->start_date ? $discount->start_date : '-' ?>
                        Дата окончания: <?= $discount->end_date ? $discount->end_date : '-' ?>
                        Тип: <?= $typeMap[$discount->type] ?>
                    </div>
                </div>

                <?

            }
        } ?>
    </div>
</div>
<style>
    .discount {
        display: flex;

    }

    .discount-container {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        margin-bottom: 20px;
    }

    .discount .discount__info {
        flex-grow: 1;
        flex-shrink: 2;
        padding: 5px;
    }

    .discount .discount__img {
        max-width: 300px;
        text-align: center;
        flex-shrink: 1;
        padding: 5px;
    }

    .discount .discount__img img {
        max-width: 100%;
    }

    .discount-container .caption {
        margin-bottom: 0;
        padding: 5px;
    }

    .discount-container .discount__footer {
        font-size: 12px;
        color: #9c9c9c;
        background-color: #f7f7f7;
        padding: 5px;
        font-style: italic;
    }

    @media (max-width: 481px) {
        .discount {
            flex-wrap: wrap;
        }

        .discount .discount__img {
            max-width: 100%;
            width: 100%;
        }

        .discount .discount__img img {
            max-height: 200px;
        }
    }
</style>




