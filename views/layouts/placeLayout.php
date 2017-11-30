<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
AppAsset::register($this);
$user = Yii::$app->user->getIdentity();
$model = $this->params['model'];
if ($model->mainImage) {
    $url = \app\components\file\ImageMainHandler::getAllImages($model->mainImage->url);
}

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
</head>
<body>
<?php $this->beginBody() ?>

<? if (!\app\components\Geo::getAcceptedCityId()) {?>

<? } ?>














<input type="checkbox" id="nav-toggle" hidden>
<nav class="nav-menu">

    <? $menu = \app\models\Category::getCategoryStructure(); ?>

    <!--
Здесь размещаете любую разметку,
если это меню, то скорее всего неупорядоченный список <ul>
-->
    <div class="nav-menu__close">X</div>
    <h2 class="logo">
        <a href="/">where-is-it</a>
    </h2>
    <ul>
        <li><a href="#1">Один</a>
        <? foreach ($menu as $key => $val) { ?>
        <li>
            <a href="#" data-id="<?= $val['id'] ?>"><?=$val['name']?>
                <? if (!empty($val['children'])) { ?>
                <div class="more"></div>
                <? } ?>
            </a>
            <? if (!empty($val['children'])) { ?>
            <ul>
                <? foreach ($val['children'] as $subVal) {?>
                <li><a href="#" data-id="<?= $subVal['id'] ?>"><?= $subVal['name'] ?></a></li>
                <? } ?>
            </ul>
            <? } ?>
        </li>
        <? } ?>
        <li><a href="#3">Три</a>
        <li><a href="#4">Четыре</a>
        <li><a href="#5">Пять</a>
        <li><a href="#6">Шесть</a>
        <li><a href="#7">Семь</a>
        <li><a href="#3">Три</a>
        <li><a href="#4">Четыре</a>
        <li><a href="#5">Пять</a>
        <li><a href="#6">Шесть</a>
        <li><a href="#7">Семь</a>
        <li><a href="#3">Три</a>
        <li><a href="#4">Четыре</a>
        <li><a href="#5">Пять</a>
        <li><a href="#6">Шесть</a>
        <li><a href="#7">Семь</a>
    </ul>
</nav>

<!--<div class="mask-content"></div>-->

<div class="wrap" style="padding:0; height:100%;">

    <!-- Попап на всякий случай -->
    <div class="modal geo-popup" id="accept-city" style="">
        <div class="modal-sandbox"></div>
        <div class="modal-box">
            <div class="modal-header" style="">
                <div class="close-modal">&#10006;</div>
                <p class="select-city">Информация по:
                    <select name="selectGeoCity" id="selectGeoCity">

                    </select>
                </p>
            </div>
            <div class="modal-body">
                <p>Выберите интересующий вас город и нажмите Ок</p>
                <button class="close-modal">Ок</button>
            </div>
        </div>
    </div>

    <? include_once(__DIR__ . '/../parts/top-menu.php'); ?>


    <div class="place-wrapper">

        <div class="title">Костел св. Барбары</div>
        <? if (isset($url)) { ?>


        <div class="image-wrapper" style="text-align:center; display:flex;">
            <nav class="place-main-menu">
                <ul id="p1">
                    <li><a href="/place/<?=$model->id?>/"><span class="glyphicon glyphicon-home"></span><span class="item-text">Главная</span></a></li>
                    <? if ($model->gallery) { ?>
                        <li><a href="/place/<?=$model->id?>/gallery/"><span class="glyphicon glyphicon-camera"></span><span class="item-text">Галлерея</span></a></li>
                    <? } ?>
                    <? if ($model->schedule) { ?>
                        <li><a href="/place/<?=$model->id?>/schedule/"> <span class="glyphicon glyphicon-time"></span><span class="item-text">Время работы</span></a></li>
                    <? } ?>
                    <? if ($model->contact) { ?>
                        <li><a href="/place/<?=$model->id?>/contacts/"> <span class="glyphicon glyphicon-phone-alt"></span><span class="item-text">Контакты</span></a></li>
                    <? } ?>
                    <? if ($model->discounts) { ?>
                        <li><a href="/place/<?=$model->id?>/discounts/"> <span class="glyphicon glyphicon-c_percent">%</span><span class="item-text">Акции, скидки</span></a></li>
                    <? } ?>
                    <? if ($model->reviews) { ?>
                        <li><a href="/place/<?=$model->id?>/reviews/"> <span style="font-size:26px;" class="glyphicon glyphicon-star"></span><span class="item-text">Отзывы</span></a></li>
                    <? } ?>

                    <!--<li><a href="#" onclick="return false;" data-modal="accept-city" class="modal-trigger glyphicon glyphicon-map-marker"></a></li>-->
                    <!--<li style="float:left"><a href="/site/login">Login</a></li>-->
                </ul>
            </nav>
            <div class="main-image" >
                <img src="<?='/' . $url['original']?>">
            </div>
        </div>
        <? } ?>

        <?= $content ?>

        <div class="place-footer">
            Вы можете помочь улучшить наш ресурс. Вы можете изменить <a href="/admin/places/?place_id=<?=$model->id?>" title="Изменить информацию об объекте" class="glyphicon icon s1 glyphicon-pencil"></a> информацию на более актуальную. Также подтвердить наличие
            объекта в этом месте либо указать что его тут нету
            <a href="#" data-vote="yes" class="glyphicon icon s1 glyphicon-eye-open js-eye" title="Подтвердить наличие объекта"></a>
            <a href="#" data-vote="no" class="glyphicon icon s1 glyphicon-eye-close js-eye" title="Подтвердить отсутствие объекта"></a>
            . Также можно пожаловаться <a target="_blank" href="/feedback/?place_id=<?=$model->id?>&type=<?=\app\constants\MessageConstants::TYPE['COMPLAIN']?>" data-vote="no" class="glyphicon icon s1 glyphicon glyphicon-warning-sign" title="Пожаловаться"></a> на информацию об объекте или оставить комментарий
            к этому месту либо дать ему оценку
            <div class="star-group">
                <a target="_blank" href="/review/?place_id=<?=$model->id?>&star=1&type=<?=\app\constants\MessageConstants::TYPE['REVIEW']?>" class="glyphicon star js-star glyphicon-star-empty" title="Оценка 1"></a>
                <a target="_blank" href="/review/?place_id=<?=$model->id?>&star=2&type=<?=\app\constants\MessageConstants::TYPE['REVIEW']?>" class="glyphicon star js-star glyphicon-star-empty" title="Оценка 2"></a>
                <a target="_blank" href="/review/?place_id=<?=$model->id?>&star=3&type=<?=\app\constants\MessageConstants::TYPE['REVIEW']?>" class="glyphicon star js-star glyphicon-star-empty" title="Оценка 3"></a>
                <a target="_blank" href="/review/?place_id=<?=$model->id?>&star=4&type=<?=\app\constants\MessageConstants::TYPE['REVIEW']?>" class="glyphicon star js-star glyphicon-star-empty" title="Оценка 4"></a>
                <a target="_blank" href="/review/?place_id=<?=$model->id?>&star=5&type=<?=\app\constants\MessageConstants::TYPE['REVIEW']?>" class="glyphicon star js-star glyphicon-star-empty" title="Оценка 5"></a>
            </div>
            на нашем ресурсе.
        </div>

        <form id="place-options" method="post">
            <input type="hidden" id="csrf" name="<?= Yii::$app->request->csrfParam; ?>"
                   value="<?= Yii::$app->request->csrfToken; ?>"/>
            <input type="hidden" id="place_id" name="placeId" value="<?=$model->id?>">
        </form>

    </div>




</div>

<!--<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?/*= date('Y') */?></p>

        <p class="pull-right"><?/*= Yii::powered() */?></p>
    </div>
</footer>-->

<?php $this->endBody() ?>

<!--<div style="border:1px solid black; position: fixed; top:50px; right: 0; width:50px height:50px;"><?/*= \app\components\Helper::getMessage() */?>sdfsdfsdfsdfsdfsdfsdf</div>-->
<?= \app\components\Helper::getMessage() ?>
<!--<div class="flash-errors">222222222<div class="close-flash">x</div></div>-->
</body>
</html>
<?php $this->endPage() ?>
