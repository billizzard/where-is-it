<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "vote".
 *
 * @property integer $id
 * @property integer $ip
 * @property integer $place_id
 * @property integer $vote
 * @property integer $created_at
 */
class Vote extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vote';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip', 'place_id', 'vote', 'created_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'Ip',
            'place_id' => 'Место',
            'vote' => 'Голос',
            'created_at' => 'Created At',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'created_at',
            ],
        ];
    }

    public static function findByPlaceAndIp($place_id, $ip = false) {
        $ip = $ip ? $ip : $_SERVER['REMOTE_ADDR'];
        return self::find()->andWhere('place_id = :place_id AND ip = :ip', [':place_id' => (int)$place_id, ':ip' => ip2long($ip)]);
    }
}
