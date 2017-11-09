<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Создать график работы';
$this->params['breadcrumbs'][] = ['label' => 'График работы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>