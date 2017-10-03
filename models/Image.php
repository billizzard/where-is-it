<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%image}}".
 *
 * @property integer id
 * @property integer place_id
 * @property string url
 * @property string description
 * @property integer status
 * @property integer type
 * @property integer created_at
 */

class Image extends \yii\db\ActiveRecord
{
    public $image;

    const STATUS_NO_MODERATE = 0;
    const STATUS_MODERATE = 1;

    const TYPE_MAIN = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%image}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['place_id', 'url'], 'required'],
            [['place_id', 'status', 'type', 'created_at'], 'number'],
            [['url'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'place_id' => 'Место',
            'status' => 'Статус',
            'type' => 'Тип',
            'url' => 'Путь',
            'description' => 'Описание',
            'created_at' => 'Дата создания',
        ];
    }


    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false
            ]
        ];
    }

    public static function getStatusesMap()
    {
        return [
            self::STATUS_NO_MODERATE => 'Не проверено',
            self::STATUS_MODERATE => 'Проверено'
        ];
    }

    public function upload($place_id = 0)
    {
        $this->place_id = $place_id;
        $url = 'uploads/' . $this->image->baseName . '.' . $this->image->extension;

        if ($this->validate()) {
            $this->url->saveAs($url);
            $this->url = $url;
            return true;
        }

        return false;
    }

}
