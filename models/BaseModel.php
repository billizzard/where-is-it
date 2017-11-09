<?php

namespace app\models;

use app\components\file\FileHelper;
use app\components\file\ImagePlaceHandler;
use app\components\SiteException;
use app\constants\AppConstants;
use app\constants\ImageConstants;
use yii\behaviors\TimestampBehavior;



class BaseModel extends \yii\db\ActiveRecord
{
    public static function findOneModel($condition)
    {
        $model = self::findOne($condition);
        if ($model) return $model;
        throw new SiteException('Объект не найден', 404);
    }

    public function getClone() {
        $class = $this::className();
        /** @var BaseModel $clone */
        $clone = new $class();
        $clone->attributes = $this->attributes;
        if ($clone->hasAttribute('parent_id')) {
            $clone->parent_id = $this->id;
        }
        return $clone;
    }

    /**
     * Можно ли тедактировать данную модель
     * @return bool
     */
    public function isUpdatable() {
        /** @var User $user */
        $user = \Yii::$app->user->getIdentity();
        if ($user->hasAccess(User::RULE_OWNER, ['model' => $this])) {
            return true;
        }
        return false;
    }

    public function isSoftDeletable() {
        /** @var User $user */
        $user = \Yii::$app->user->getIdentity();
        if ($user->hasAccess(User::RULE_OWNER, ['model' => $this])) {
            return true;
        }
        return false;
    }

    public function isDeletable() {
        /** @var User $user */
        $user = \Yii::$app->user->getIdentity();
        if ($user->hasAccess(User::RULE_DELETE_MODEL_FULL)) {
            return true;
        }
        return false;
    }



}
