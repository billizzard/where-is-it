<?php

namespace app\models;

use app\constants\ImageConstants;
use Yii;

/**
 * This is the model class for table "discount".
 *
 * @property integer $id
 * @property integer $image_id
 * @property integer $place_id
 * @property string $title
 * @property string $message
 * @property integer $type
 * @property integer $status
 * @property string $start_date
 * @property string $end_date
 * @property boolean is_deleted
 * @property integer $created_at
 */
class Discount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'discount';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image_id', 'place_id', 'type', 'status', 'created_at'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['is_deleted'], 'boolean'],
            [['title'], 'string', 'max' => 150],
            [['message'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image_id' => 'Изображение',
            'place_id' => 'Место',
            'title' => 'Заголовок',
            'message' => 'Сообщение',
            'type' => 'Тип',
            'status' => 'Статус',
            'start_date' => 'Дата начала',
            'end_date' => 'Дата окончания',
            'created_at' => 'Дата создания',
            'is_deleted' => 'Удалено ли',
        ];
    }

    public static function findByPlaceId($place_id)
    {
        return self::find()->andWhere(['place_id' => (int)$place_id]);
    }

    public static function findByPlaceAndStatus($place_id, $status) {
        return self::findByPlaceId($place_id)->andWhere(['status' => (int)$status]);
    }

    public function getMainImage()
    {
        return $this->hasOne(Image::className(), ['place_id' => 'id'])->andWhere(['image.type' => ImageConstants::TYPE['MAIN_DISCOUNT']]);
    }

    public function getPlace() {
        return $this->hasOne(Place::className(), ['id' =>'place_id']);
    }

    public static function getNoCheckModel() {
        return null;
    }
}
