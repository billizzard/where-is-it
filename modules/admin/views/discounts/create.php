<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Создать скидку, акцию';
$this->params['breadcrumbs'][] = ['label' => 'Скидки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">


    <?= $this->render('_form', [
        'model' => $model,
        'modelImage' => $modelImage
    ]) ?>

</div>