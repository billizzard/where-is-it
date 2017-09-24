<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class PlaceForm extends Model
{
    public $name;
    public $category_id;
    public $lat;
    public $lon;
    public $address;
    public $category;
    public $description;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'category_id', 'lat', 'lon'], 'required'],
            [['lat', 'lon', 'category_id'], 'number'],
            [['name'], 'string', 'max' => 1],
            [['address'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'category_id' => 'Категория',
            'lat' => 'Координаты',
            'lon' => 'Координаты',
            'address' => 'Адрес',
            'category' => 'Категория',
            'description' => 'Описание',
        ];
    }

}
