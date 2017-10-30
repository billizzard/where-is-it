<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%city}}".
 *
 * @property integer id
 * @property string name
 */

class City extends BaseModel
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%city}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
        ];
    }

    /**
     * @param $name
     * @return ActiveQuery
     */
    public static function findByName($name)
    {
        return self::find()->andWhere('name = :name', [':name' => $name]);
    }

    public static function getDefaultCity()
    {
        return self::findOne(1);
    }

    public static function getCityMap()
    {
        $result = [];
        $models = self::find()->select(['id', 'name'])->asArray()->orderBy(['name' => SORT_ASC])->all();

        foreach ($models as $model) {
            $result[$model['id']] = $model['name'];
        }
        return $result;
    }
}
