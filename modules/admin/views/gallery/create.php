<?php

/* @var $this yii\web\View */
/* @var $model app\models\Gallery */

$this->title = 'Создать галлерею';
$this->params['breadcrumbs'][] = ['label' => 'Галлереи', 'url' => ['index', 'place_id' => $model->place_id]];
?>
<div class="user-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>