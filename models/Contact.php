<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contact".
 *
 * @property integer $id
 * @property string $phone
 * @property string $email
 * @property integer $parent_id
 * @property integer $created_at
 * @property integer $place_id
 * @property integer $status
 */
class Contact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone', 'email'], 'string'],
            [['parent_id', 'created_at', 'place_id', 'status'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone' => 'Телефоны',
            'email' => 'Email',
            'parent_id' => 'Родитель',
            'created_at' => 'Дата создания',
            'place_id' => 'Место',
            'status' => 'Статус',
        ];
    }
}
