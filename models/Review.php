<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "review".
 *
 * @property integer $id
 * @property integer $place_id
 * @property string $message
 * @property integer $star
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $status
 * @property boolean is_deleted
 */
class Review extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'review';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['place_id', 'created_at', 'user_id', 'status'], 'integer'],
            [['message'], 'string', 'max' => 1000],
            [['is_deleted'], 'boolean'],
            [['star', 'place_id', 'user_id'], 'required'],
            ['star', 'integer', 'min' => 1, 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'place_id' => 'Место',
            'message' => 'Сообщение',
            'star' => 'Звезды',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'is_deleted' => 'Удалено ли',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false,
            ],
        ];
    }

    public static function findByPlaceAndUserId($place_id, $user_id) {
        return self::find()->andWhere(['place_id' => (int)$place_id, 'user_id' => (int)$user_id]);
    }

    public static function getSumStarByPlace($place_id) {
        return self::find()->andWhere(['place_id' => (int)$place_id])->select('sum(star) as sum, COUNT(*) as count')->asArray()->one();
    }
}
