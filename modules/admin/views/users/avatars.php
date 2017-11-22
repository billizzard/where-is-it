<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $avatars array */


$this->title = 'Аватары';
$this->params['breadcrumbs'][] = $this->title;
/** @var \app\models\User $user */
$user = Yii::$app->user->getIdentity();
$dir = '/img/avatars/mult/'
?>
<div class="avatar-index">
    <div class="avatars">
        <? foreach ($avatars as $avatar) { ?>
        <div class="avatar <?=$user->avatar == $avatar ? 'picked' : ''?>">
            <img src="<?=$dir . $avatar?>">
            <div class="avatar-pick">выбрать</div>
        </div>
        <? } ?>
    </div>
</div>
<style>
    .avatar-index .avatars {
        display:flex;
        flex-wrap: wrap;
    }
    .avatar-index .avatars .avatar.picked {
        border-color:#73c373;
    }
    .avatar-index .avatars .avatar {
        margin:5px;
        position:relative;
        border:3px solid #fff;
        box-shadow: 0 0 10px rgba(0,0,0,0.5);
    }
    .avatar-index .avatars .avatar div {
        position: absolute;
        bottom: 0;
        text-align: center;
        width: 100%;
        background-color: rgba(255, 255, 255, 0.66);
        color: #000;
        padding: 2px;
        cursor: pointer;

    }
    .avatar-index .avatars .avatar div:active {
        background-color: rgba(160, 160, 160, 0.66);
    }
</style>
