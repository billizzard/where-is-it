<?php

namespace app\models;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property integer id
 * @property string name
 * @property string parent_id
 * @property string sort
 */

class Category extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent_id', 'sort'], 'integer'],
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
            'parent_id' => 'Родитель',
            'sort' => 'Сортировка',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }


    public static function getCategoriesMap() {
        $map = [];
        $models = self::find()->select(['id', 'name'])->asArray()->all();

        if ($models) {
            foreach ($models as $model) {
                $map[$model['id']] = $model['name'];
            }
        }

        return $map;
    }

    public static function getCategoryStructure() {
        $models = self::find()->select(['id', 'name', 'parent_id'])->asArray()->orderBy(['name' => SORT_ASC])->all();
        if ($models) {
            foreach ($models as $model) {

            }
        }
    }

}
