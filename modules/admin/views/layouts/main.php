<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */


    dmstr\web\AdminLteAsset::register($this);
    \app\modules\admin\assets\AdminAssets::register($this);
    //app\assets\AppAsset::register($this);


    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    $user = Yii::$app->user->getIdentity();
    $class = '';
if (!$user || $user->hasAccess(\app\constants\UserConstants::RULE['ADMIN_PANEL'])) {
    $class = 'guest-wrapper';
}
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    </head>
    <!--
    "skin-blue",
"skin-black",
"skin-red",
"skin-yellow",
"skin-purple",
"skin-green",
"skin-blue-light",
"skin-black-light",
"skin-red-light",
"skin-yellow-light",
"skin-purple-light",
"skin-green-light"
    -->
    <body class="hold-transition skin-blue sidebar-mini">
    <?php $this->beginBody() ?>
    <div class="wrapper ">

        <?
        //if ($user && $user->hasAccess(\app\models\User::RULE_ADMIN_PANEL)) {
            echo $this->render(
                'header.php',
                ['directoryAsset' => $directoryAsset]
            );
        //}
        ?>

        <?
        //if ($user && $user->hasAccess(\app\models\User::RULE_ADMIN_PANEL)) {
            echo $this->render(
                'left.php',
                ['directoryAsset' => $directoryAsset]
            );
        //}
        ?>

        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>

    </div>

    <?php $this->endBody() ?>
    <?= \app\components\Helper::getMessage() ?>

    </body>

    <!--<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.min.css">

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.full.min.js"></script>
   --> </html>
    <?php $this->endPage() ?>
<?php //} ?>
