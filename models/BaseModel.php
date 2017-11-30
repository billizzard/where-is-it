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

    /**
     * Делает пометку в объекте, что он удален
     * @return bool
     */
    public function softDelete() {
        if ($this->hasAttribute('is_deleted')) {
            $this->is_deleted = true;
            if ($this->save()) {
                return true;
            }
        }
        return false;
    }

//    public function cloneParentImages() {
//        if ($this->hasAttribute('parent_id')) {
//            $parent = $this::className()::findOne($this->parent_id);
//            if ($parent) {
//                foreach ($parent->images as $image) {
//                    Image::createImageFromTemp($this, '/'.$image->url, $this->getDir(), $image->type);
//                }
//            }
//        }
//    }

    public function getDuplicate() {
        /** @var User $user */
        $user = \Yii::$app->user->getIdentity();
        return $user && $user->hasAccess(User::RULE_NO_DUPLICATE) ? $this : $this->createDuplicate();
    }

    public function createDuplicate() {
        $class = $this::className();
        /** @var BaseModel $clone */
        $clone = new $class();
        $clone->attributes = $this->attributes;
        if ($clone->hasAttribute('parent_id')) {
            $clone->parent_id = $this->id;
        }
        if ($clone->hasAttribute('status')) {
            $clone->status = AppConstants::STATUS['NO_MODERATE'];
        }
        return $clone;
    }

    /**
     * Можно ли редактировать данную модель
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

    public static function find()
    {
        return parent::find()->andWhere([static::tableName() . '.is_deleted' => false]); // TODO: Change the autogenerated stub
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            if ($this->hasAttribute('ip')) {
                $this->ip = ip2long($_SERVER['REMOTE_ADDR']);
            }
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public function getDir() {
        return $this->place->getDir();
    }


}
