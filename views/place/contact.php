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
<style>
    .place-page {
        color:#8b8e91;
        padding:5px;
        margin-bottom:20px;
    }

    .place-page .place-page__title {
        text-align: center;
        font-size: 22px;
        /* text-decoration: underline; */
        border-bottom: 3px double;
        /* background-color: #7096d2; */
        /* color: #383838; */
        padding-bottom: 5px;
        padding-top: 5px;
    }
    .place-contact  .contact {
        display:flex;
        flex-wrap: wrap;
        margin: 10px 10px 0 0;
    }
    .place-contact .contact>dev {
        margin: 0 10px 0 0;
    }
    .place-contact .contact__title {
        min-width:80px;
        color: #777;
        text-align: left;
        font-weight: bold;
        margin-right:10px;
    }

    .place-contact  .contact {
        background-color: transparent;
    }

</style>



