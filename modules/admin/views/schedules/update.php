<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Schedule */

$this->title = 'Изменить график работы';
$this->params['breadcrumbs'][] = ['label' => 'Графики работы', 'url' => ['index', 'place_id' => $model->place_id]];
?>
<div class="user-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>