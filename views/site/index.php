<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>

<div id="ymap" style="width:100%; height:100vh;"></div>
<input type="hidden" id="csrfParam" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />

