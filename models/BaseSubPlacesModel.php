<?php

namespace app\models;

use app\constants\AppConstants;

class BaseSubPlacesModel extends BaseModel implements ISubPlaces
{
    /**
     * Можно ли добавить больше моделей для этого места в базу
     * @param $place_id
     * @return bool
     */
    public static function isCanAddMore($place_id) {
        $class = static::className();
        $count = $class::find()->andWhere(['place_id' => (int)$place_id, 'status' => AppConstants::STATUS['NO_MODERATE']])->count();
        return $count < AppConstants::COUNT_COPIES;
    }

    /**
     * Можно ли обновлять модель, так как при обновлении создается новая модель и есть предел
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
            return date('H:i:s d-m-Y', $this->created_at);
        }
    }

}
