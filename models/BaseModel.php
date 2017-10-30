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

}
