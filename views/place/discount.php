<?php

/* @var $this yii\web\View */
/* @var $discounts \app\models\Discount[] */

$this->title = 'My Yii Application';

?>
<div class="place-contact place-page">

    <h3>Акции, скидки</h3>
    <div class="discounts-container"></div>
    <? if ($discounts) {
        foreach ($discounts as $discount) {
            if ($discount->type == \app\constants\DiscountConstants::TYPE['ACTION']) {
                ?>

                <div class="discount">
                    <?
                    /** @var \app\models\Image $image */
                    if ($image = $discount->mainImage) {
                        $sizes = $image->getImageSizes();
                        ?>
                    <div class="img">
                        <img src="/<?=$sizes['discount_']?>">
                    </div>
                    <? } ?>
                    <div class="info">
                        <? if ($discount->title) { ?>
                        <h4><?= $discount->title ?></h4>
                    <? }?>
                        <div class="message">
                            <?=nl2br($discount->message)?>
                        </div>
                    </div>
                </div>

                <?
            }
        }
    }?>

</div>




