<?php

namespace app\models;

use app\components\file\FileHelper;
use app\components\file\ImagePlaceHandler;
use app\components\SiteException;
use app\constants\AppConstants;
use app\constants\ImageConstants;
use yii\behaviors\TimestampBehavior;

class BaseSubPlacesModel extends BaseModel implements ISubPlaces
{
    /**
     * Можно ли добавить больше моделей в базу
     * @param $place_id
     * @return bool
     */
    public static function isCanAddMore($place_id) {
        $class = static::className();
        $count = $class::find()->andWhere(['place_id' => (int)$place_id, 'status' => AppConstants::STATUS['NO_MODERATE']])->count();
        return $count < AppConstants::COUNT_COPIES;
    }

    /**
     * Можно ли обновлять модель, так как создается новая модель
     * @return bool
     */
    public function isUpdatable() {
        if ($this->hasAttribute('place_id')) {
            return self::isCanAddMore($this->place_id);
        }
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlace()
    {
        return $this->hasOne(Place::className(), ['id' => 'place_id']);
    }

    /**
     * @param $place_id
     * @return $this
     */
    public static function findByPlaceId($place_id)
    {
        return self::find()->andWhere('place_id = :place_id', [':place_id' => $place_id]);
    }

    public static function findByPlaceAndStatus($place_id, $status) {
        return self::findByPlaceId($place_id)->andWhere('status = :status', [':status' => $status]);
    }

    public function getCreatedData() {
        if ($this->created_at) {
            return date('H:i:s d-m-Y');
        }
    }

}
