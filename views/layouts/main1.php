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

    <!--
Здесь размещаете любую разметку,
если это меню, то скорее всего неупорядоченный список <ul>
-->
    <h2 class="logo">
        <a href="//dbmast.ru/">DBmast.ru</a>
    </h2>
    <ul>
        <li><a href="#1">Один</a>
        <li><a href="#2">Два</a>
        <li><a href="#3">Три</a>
        <li><a href="#4">Четыре</a>
        <li><a href="#5">Пять</a>
        <li><a href="#6">Шесть</a>
        <li><a href="#7">Семь</a>
    </ul>
</nav>

<style>

    /**
     * Переключаемая боковая панель навигации
     * выдвигающаяся по клику слева
     */

    .nav-menu {
        /*  ширна произвольная, не стесняйтесь экспериментировать */
        width: 320px;
        min-width: 320px;
        /* фиксируем и выставляем высоту панели на максимум */
        height: 100%;
        position: fixed;
        top: 0;
        bottom: 0;
        margin: 0;
        /* сдвигаем (прячем) панель относительно левого края страницы */
        left: -320px;
        /* внутренние отступы */
        padding: 15px 20px;
        /* плавный переход смещения панели */
        -webkit-transition: left 0.3s;
        -moz-transition: left 0.3s;
        transition: left 0.3s;
        /* определяем цвет фона панели */
        background: #373c3b;
        /* поверх других элементов */
        z-index: 2000;
    }


    /**
     * Кнопка переключения панели
     * тег <label>
     */

    .nav-toggle {
        /* абсолютно позиционируем */
        position: absolute;
        /* относительно левого края панели */
        left: 320px;
        /* отступ от верхнего края панели */
        top: 1em;
        /* внутренние отступы */
        padding: 0.5em;
        /* определяем цвет фона переключателя
         * чаще вчего в соответствии с цветом фона панели
        */
        background: inherit;
        /* цвет текста */
        color: #dadada;
        /* вид курсора */
        cursor: pointer;
        /* размер шрифта */
        font-size: 1.2em;
        line-height: 1;
        /* всегда поверх других элементов страницы */
        z-index: 2001;
        /* анимируем цвет текста при наведении */
        -webkit-transition: color .25s ease-in-out;
        -moz-transition: color .25s ease-in-out;
        transition: color .25s ease-in-out;
    }


    /* определяем текст кнопки
     * символ Unicode (TRIGRAM FOR HEAVEN)
    */

    .nav-toggle:after {
        content: '\2630';
        text-decoration: none;
    }


    /* цвет текста при наведении */

    .nav-toggle:hover {
        color: #f4f4f4;
    }


    /**
     * Скрытый чекбокс (флажок)
     * невидим и недоступен :)
     * имя селектора атрибут флажка
     */

    [id='nav-toggle'] {
        position: absolute;
        display: none;
    }


    /**
     * изменение положения переключателя
     * при просмотре на мобильных устройствах
     * когда навигация раскрыта, распологаем внутри панели
    */

    [id='nav-toggle']:checked ~ .nav-menu > .nav-toggle {
        left: auto;
        right: 2px;
        top: 1em;
    }


    /**
     * Когда флажок установлен, открывается панель
     * используем псевдокласс:checked
     */

    [id='nav-toggle']:checked ~ .nav-menu {
        left: 0;
        box-shadow:4px 0px 20px 0px rgba(0,0,0, 0.5);
        -moz-box-shadow:4px 0px 20px 0px rgba(0,0,0, 0.5);
        -webkit-box-shadow:4px 0px 20px 0px rgba(0,0,0, 0.5);
        overflow-y: auto;
    }


    /*
     * смещение контента страницы
     * на размер ширины панели,
     * фишка необязательная, на любителя
    */

    [id='nav-toggle']:checked ~ main > article {
        -webkit-transform: translateX(320px);
        -moz-transform: translateX(320px);
        transform: translateX(320px);
    }


    /*
     * изменение символа переключателя,
     * привычный крестик (MULTIPLICATION X),
     * вы можете испльзовать любой другой значок
    */

    [id='nav-toggle']:checked ~ .nav-menu > .nav-toggle:after {
        content: '\2715';
    }


    /**
     * профиксим баг в Android <= 4.1.2
     * см: http://timpietrusky.com/advanced-checkbox-hack
     */

    body {
        -webkit-animation: bugfix infinite 1s;
    }

    @-webkit-keyframes bugfix {
        to {
            padding: 0;
        }
    }


    /**
     * позаботьтимся о средних и маленьких экранах
     * мобильных устройств
     */

    @media screen and (min-width: 320px) {
        html,
        body {
            margin: 0;
            overflow-x: hidden;
        }
    }

    @media screen and (max-width: 320px) {
        html,
        body {
            margin: 0;
            overflow-x: hidden;
        }
        .nav-menu {
            width: 100%;
            box-shadow: none
        }
    }


    /**
     * Формируем стиль заголовка (логотип) панели
    */

    .nav-menu h2 {
        width: 90%;
        padding: 0;
        margin: 10px 0;
        text-align: center;
        text-shadow: rgba(255, 255, 255, .1) -1px -1px 1px, rgba(0, 0, 0, .5) 1px 1px 1px;
        font-size: 1.3em;
        line-height: 1.3em;
        opacity: 0;
        transform: scale(0.1, 0.1);
        -ms-transform: scale(0.1, 0.1);
        -moz-transform: scale(0.1, 0.1);
        -webkit-transform: scale(0.1, 0.1);
        transform-origin: 0% 0%;
        -ms-transform-origin: 0% 0%;
        -moz-transform-origin: 0% 0%;
        -webkit-transform-origin: 0% 0%;
        transition: opacity 0.8s, transform 0.8s;
        -ms-transition: opacity 0.8s, -ms-transform 0.8s;
        -moz-transition: opacity 0.8s, -moz-transform 0.8s;
        -webkit-transition: opacity 0.8s, -webkit-transform 0.8s;
    }

    .nav-menu h2 a {
        color: #dadada;
        text-decoration: none;
        text-transform: uppercase;
    }


    /*плавное появление заголовка (логотипа) при раскрытии панели */

    [id='nav-toggle']:checked ~ .nav-menu h2 {
        opacity: 1;
        transform: scale(1, 1);
        -ms-transform: scale(1, 1);
        -moz-transform: scale(1, 1);
        -webkit-transform: scale(1, 1);
    }


    /**
     * формируем непосредственно само меню
     * используем неупорядоченный список для пунктов меню
     * прикрутим трансфомации и плавные переходы
     */

    .nav-menu > ul {
        display: block;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .nav-menu > ul > li {
        line-height: 2.5;
        opacity: 0;
        -webkit-transform: translateX(-50%);
        -moz-transform: translateX(-50%);
        -ms-transform: translateX(-50%);
        transform: translateX(-50%);
        -webkit-transition: opacity .5s .1s, -webkit-transform .5s .1s;
        -moz-transition: opacity .5s .1s, -moz-transform .5s .1s;
        -ms-transition: opacity .5s .1s, -ms-transform .5s .1s;
        transition: opacity .5s .1s, transform .5s .1s;
    }

    [id='nav-toggle']:checked ~ .nav-menu > ul > li {
        opacity: 1;
        -webkit-transform: translateX(0);
        -moz-transform: translateX(0);
        -ms-transform: translateX(0);
        transform: translateX(0);
    }


    /* определяем интервалы появления пунктов меню */

    .nav-menu > ul > li:nth-child(2) {
        -webkit-transition: opacity .5s .2s, -webkit-transform .5s .2s;
        transition: opacity .5s .2s, transform .5s .2s;
    }

    .nav-menu > ul > li:nth-child(3) {
        -webkit-transition: opacity .5s .3s, -webkit-transform .5s .3s;
        transition: opacity .5s .3s, transform .5s .3s;
    }

    .nav-menu > ul > li:nth-child(4) {
        -webkit-transition: opacity .5s .4s, -webkit-transform .5s .4s;
        transition: opacity .5s .4s, transform .5s .4s;
    }

    .nav-menu > ul > li:nth-child(5) {
        -webkit-transition: opacity .5s .5s, -webkit-transform .5s .5s;
        transition: opacity .5s .5s, transform .5s .5s;
    }

    .nav-menu > ul > li:nth-child(6) {
        -webkit-transition: opacity .5s .6s, -webkit-transform .5s .6s;
        transition: opacity .5s .6s, transform .5s .6s;
    }

    .nav-menu > ul > li:nth-child(7) {
        -webkit-transition: opacity .5s .7s, -webkit-transform .5s .7s;
        transition: opacity .5s .7s, transform .5s .7s;
    }


    /**
     * оформление ссылок пунктов меню
     */

    .nav-menu > ul > li > a {
        display: inline-block;
        position: relative;
        padding: 0;
        font-family: 'Open Sans', sans-serif;
        font-weight: 300;
        font-size: 1.2em;
        color: #dadada;
        width: 100%;
        text-decoration: none;
        /* плавный переход */
        -webkit-transition: color .5s ease, padding .5s ease;
        -moz-transition: color .5s ease, padding .5s ease;
        transition: color .5s ease, padding .5s ease;
    }


    /**
     * состояние ссылок меню при наведении
     */

    .nav-menu > ul > li > a:hover,
    .nav-menu > ul > li > a:focus {
        color: white;
        padding-left: 15px;
    }


    /**
     * линия подчеркивания ссылок меню
     */

    .nav-menu > ul > li > a:before {
        content: '';
        display: block;
        position: absolute;
        right: 0;
        bottom: 0;
        height: 1px;
        width: 100%;
        -webkit-transition: width 0s ease;
        transition: width 0s ease;
    }

    .nav-menu > ul > li > a:after {
        content: '';
        display: block;
        position: absolute;
        left: 0;
        bottom: 0;
        height: 1px;
        width: 100%;
        background: #3bc1a0;
        -webkit-transition: width .5s ease;
        transition: width .5s ease;
    }


    /**
     * анимируем линию подчеркивания
     * ссылок при наведении
     */

    .nav-menu > ul > li > a:hover:before {
        width: 0%;
        background: #3bc1a0;
        -webkit-transition: width .5s ease;
        transition: width .5s ease;
    }

    .nav-menu > ul > li > a:hover:after {
        width: 0%;
        background: transparent;
        -webkit-transition: width 0s ease;
        transition: width 0s ease;
    }


    /* фон затемнения на основной контент
     * при этом элементы блокируютя
     * спорная такая фича, если оно вам надо
     * просто раскомментируйте
    */

    /*
    .mask-content {
        display: block;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4);
        visibility: hidden;
        opacity: 0;
    }

    [id='nav-toggle']:checked ~ .mask-content {
        visibility: visible;
        opacity: 1;
        -webkit-transition: opacity .5s, visibility .5s;
        transition: opacity .5s, visibility .5s;
    }
    */
</style>




<div class="wrap" style="padding:0;">


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
</body>
</html>
<?php $this->endPage() ?>