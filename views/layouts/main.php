<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
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



<input type="checkbox" id="nav-toggle" hidden>
<nav class="nav-menu">

    <? $menu = \app\models\Category::getCategoryStructure(); ?>

    <!--
Здесь размещаете любую разметку,
если это меню, то скорее всего неупорядоченный список <ul>
-->
    <h2 class="logo">
        <a href="//dbmast.ru/">DBmast.ru</a>
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
    </ul>
</nav>

<!--<div class="mask-content"></div>-->

<div class="wrap" style="padding:0; height:100%;">


    <nav id="w0" class="navbar-inverse navbar-fixed-top navbar" role="navigation"><div class="container"><div class="navbar-header"><button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#w0-collapse"><span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span></button><a class="navbar-brand" href="/">My Company</a></div><div id="w0-collapse" class="collapse navbar-collapse"><ul id="w1" class="navbar-nav navbar-right nav"><li class="active"><a href="/site/index">Home</a></li>
                    <li><a href="#" class="nav-toggle1">About</a></li>
                    <li><a href="/site/contact">Contact</a></li>
                    <li><a href="/site/login">Login</a></li></ul></div></div></nav>



    <?= $content ?>

</div>

<!--<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?/*= date('Y') */?></p>

        <p class="pull-right"><?/*= Yii::powered() */?></p>
    </div>
</footer>-->

<?php $this->endBody() ?>
<?= \app\components\Helper::getErrors() ?>
<!--<div class="flash-errors">222222222<div class="close-flash">x</div></div>-->
</body>
</html>
<?php $this->endPage() ?>
