<?php

namespace app\models;

use app\constants\ImageConstants;
use app\models\traits\UrlImageUploader;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "gallery".
 *
 * @property integer $id
 * @property string $title
 * @property integer $place_id
 * @property integer $ip
 * @property integer $parent_id
 * @property integer $status
 * @property integer $created_at
 * @property boolean is_deleted
 */
class Gallery extends BaseSubPlacesModel
{
    use UrlImageUploader;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gallery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255],
            [['is_deleted'], 'boolean'],
            [['place_id', 'parent_id', 'status', 'created_at', 'ip'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'place_id' => 'Место',
            'ip' => 'Ip',
            'parent_id' => 'Родитель',
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
                'updatedAtAttribute' => false
            ]
        ];
    }

    public function getImages()
    {
        return $this->hasMany(Image::className(), ['place_id' => 'id'])->andWhere(['type' => ImageConstants::TYPE['GALLERY']]);
    }
}
