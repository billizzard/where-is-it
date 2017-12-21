<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;
AppAsset::register($this);
$user = Yii::$app->user->getIdentity();
$menu = \app\models\Category::getCategoryStructure();
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

    <?= $content ?>

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
