<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "message".
 *
 * @property integer $id
 * @property string $email
 * @property string $message
 * @property integer $type
 * @property integer $place_id
 * @property integer $created_at
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'email', 'message'], 'required'],
            [['message'], 'string'],
            [['type', 'created_at', 'place_id'], 'integer'],
            [['email'], 'string', 'max' => 100],
            [['email'], 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'message' => 'Сообщение',
            'type' => 'Тип',
            'place_id' => 'Место',
            'created_at' => 'Дата создания',
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
}
