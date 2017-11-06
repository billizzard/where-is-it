<?php
use backend\assets\AppAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

dmstr\web\AdminLteAsset::register($this);
\app\modules\admin\assets\AdminAssets::register($this);
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
</head>
<body class="login-page">

<?php $this->beginBody() ?>

<nav id="w0" class="navbar-inverse navbar-fixed-top navbar" role="navigation">
    <div class="container">
        <div>
            <ul id="w1" class="navbar-nav navbar-left nav" >
                <li style="float:left"><a href="/" class="glyphicon glyphicon-home" style="font-size:22px;"></a></li>
            </ul>
        </div>
    </div>
</nav>


    <?= $content ?>

<?php $this->endBody() ?>
<?= \app\components\Helper::getMessage() ?>
</body>
</html>
<?php $this->endPage() ?>
