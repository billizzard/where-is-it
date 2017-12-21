<?php

namespace app\models\forms;

use app\models\City;
use app\models\Place;
use mongosoft\file\UploadBehavior;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class AddForm extends City
{
    public $lat;
    public $lon;
    public $status;
    public $image;

    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['lat', 'lon'], 'number'],
            [['status'], 'integer'],
            ['name', 'image', 'extensions' => 'jpg, jpeg, gif, png', 'on' => ['insert', 'update']],
        ];
    }


    function behaviors()
    {
        return [
            [
                'class' => UploadBehavior::className(),
                'attribute' => 'name',
                'scenarios' => ['insert', 'update'],
                'path' => '@webroot/upload/docs/{id}',
                'url' => '@web/upload/docs/{id}',
            ],
        ];
    }


}
