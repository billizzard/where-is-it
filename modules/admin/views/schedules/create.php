<?php

/* @var $this yii\web\View */
/* @var $model app\models\Schedule */

$this->title = 'Создать график работы';
$this->params['breadcrumbs'][] = ['label' => 'Графики работы', 'url' => ['index', 'place_id' => $model->place_id]];
?>
<div class="user-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>