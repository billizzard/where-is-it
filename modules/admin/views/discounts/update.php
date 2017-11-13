<?php

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Обновить скидку';
$this->params['breadcrumbs'][] = ['label' => 'Места', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="user-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>