<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gallery".
 *
 * @property integer $id
 * @property string $title
 * @property integer $place_id
 * @property string $ip
 * @property integer $parent_id
 * @property integer $status
 * @property integer $created_at
 * @property boolean is_deleted
 */
class Gallery extends BaseSubPlacesModel
{
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
            [['title', 'ip'], 'string'],
            [['is_deleted'], 'boolean'],
            [['place_id', 'parent_id', 'status', 'created_at'], 'integer'],
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
}
