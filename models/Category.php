<?php

namespace app\models;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property integer id
 * @property string name
 * @property string parent_id
 * @property string color
 * @property string sort
 * @property boolean is_deleted
 */

class Category extends BaseModel
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
            [['is_deleted'], 'boolean'],
            [['parent_id', 'sort'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['color'], 'string', 'max' => 6],

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
            'color' => 'Цвет',
            'is_deleted' => 'Удалено ли',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Возвращает массив категорий
     * @return array
     */
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

    /**
     * Возвращает структурированный массив категорий
     * @return array
     */
    public static function getCategoryStructure() {
        $models = self::find()->select(['id', 'name', 'parent_id'])->asArray()->orderBy(['name' => SORT_ASC])->all();
        $menu = [];
        if ($models) {
            /** @var Category $model */
            foreach ($models as $model) {
                if (!$model['parent_id']) {
                    $menu[$model['id']] = $model;
                }
            }

            foreach ($models as $model) {
                if ($model['parent_id']) {
                    if (isset($menu[$model['parent_id']])) {
                        $menu[$model['parent_id']]['children'][$model['id']] = $model;
                    }
                }
            }
        }
        return $menu;
    }

}
