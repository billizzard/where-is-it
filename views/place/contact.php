<?php

/* @var $this yii\web\View */
/* @var $contact \app\models\Contact*/

$this->title = 'My Yii Application';

?>
<div class="place-contact place-page">

    <h3>Контакты</h3>

    <? if ($contact->phone) { ?>
    <div class="contact">
        <div class="contact__title">Телефоны: </div>
        <div class="contact__info"><?=nl2br($contact->phone)?></div>
    </div>
    <? } ?>

    <? if ($contact->email) { ?>
        <div class="contact">
            <div class="contact__title">Email: </div>
            <div class="contact__info"><?=nl2br($contact->email)?></div>
        </div>
    <? } ?>

</div>



