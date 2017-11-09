<?php

namespace app\models;

use app\components\file\FileHelper;
use app\components\file\ImagePlaceHandler;
use app\constants\AppConstants;
use app\constants\ImageConstants;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%place}}".
 *
 * @property integer id
 * @property string name
 * @property string description
 * @property integer category_id
 * @property integer status
 * @property integer user_id
 * @property integer yes
 * @property integer no
 * @property integer type
 * @property double lat
 * @property double lon
 * @property string address
 * @property string work_time
 * @property string dir
 * @property string created_ip
 * @property integer created_at
 * @property integer updated_at
 * @property integer parent_id
 * @property integer stars
 * @property integer stars_count
 * @property boolean is_deleted
 */

class Place extends BaseModel
{
    public $category;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%place}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'category_id', 'lat', 'lon'], 'required'],
            [['lat', 'lon'], 'number'],
            [['yes', 'no', 'type', 'category_id', 'status', 'user_id', 'parent_id', 'stars_count'], 'integer'],
            [['name', 'address'], 'string', 'max' => 255],
            [['dir'], 'string', 'max' => 100],
            [['stars'], 'number', 'min' => 1, 'max' => 5],
            [['description', 'work_time'], 'string', 'max' => 500],
            [['category'], 'string'],
            [['is_deleted'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'category_id' => 'Категория',
            'user_id' => 'Пользователь',
            'dir' => 'Директория с изображениями',
            'lat' => 'Координаты',
            'lon' => 'Координаты',
            'yes' => 'Кол-во подтверждений',
            'no' => 'Кол-во не подтверждений',
            'type' => 'Тип',
            'address' => 'Адрес',
            'stars' => 'Средняя оценка',
            'stars_count' => 'Количество оценок',
            'description' => 'Описание',
            'work_time' => 'Время работы',
            'created_ip' => 'ip создателя',
            'status' => 'Статус',
            'parent_id' => 'Родитель',
            'is_deleted' => 'Удалено ли',
        ];
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_ip = $_SERVER['REMOTE_ADDR'];
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            if ($dir = ImagePlaceHandler::createSaveDir($this->id)) {
                $this->dir = $dir;
                $this->save();
            }
        }
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    public function beforeDelete()
    {
        if ($dir = $this->getFullDir()) {
            FileHelper::removeDir($dir);
        }
        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }

    public static function findByCategoryId($category_id, $size) {
        $category_id = (int)$category_id;
        $latMin = $size[0][0];
        $latMax = $size[1][0];
        $lonMin = $size[0][1];
        $lonMax = $size[1][1];
        return self::findPlace()->andWhere(['category_id' => $category_id])
            ->andWhere('lat >= :latMin AND lat <= :latMax AND lon >= :lonMin AND lon <= :lonMax',
                ['latMin' => $latMin, 'latMax' => $latMax, 'lonMin' => $lonMin, 'lonMax' => $lonMax])
            //->joinWith('mainImage');
            ->leftJoin('image', 'image.place_id = place.id AND image.type = 0');
    }

    public static function findPlace() {
        return self::find()->andWhere(['place.status' => AppConstants::STATUS['MODERATE']]);
    }

    public static function findPlaceById($id) {
        return self::findPlace()->andWhere(['id' => (int)$id]);
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                //'updatedAtAttribute' => false
            ]
        ];
    }

    public function getMainImage()
    {
        return $this->hasOne(Image::className(), ['place_id' => 'id'])->andWhere(['image.type' => ImageConstants::TYPE['MAIN']]);
    }

    public function getGallery()
    {
        return $this->hasMany(Image::className(), ['place_id' => 'id'])->andWhere(['image.type' => ImageConstants::TYPE['GALLERY']]);
    }

    public function getGalleryNewVariant()
    {
        return $this->hasMany(Image::className(), ['place_id' => 'id'])->andWhere(['image.type' => ImageConstants::TYPE['GALLERY_NEW_VARIANT']]);
    }

    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getFullDir() {
        return \Yii::getAlias('@webroot') . '/' . $this->getDir();
    }

    public function getDir() {
        if (!$this->dir) {
            $this->dir = ImagePlaceHandler::createSaveDir($this->id);
            $this->save();
        }
        return $this->dir;
    }

    public function getDescription() {
        return $this->description;
    }

    public function isCanAddGallery()
    {
        if (!$this->gallery || !$this->galleryNewVariant) {
            return true;
        }
        /** @var User $user */
        if ($user = \Yii::$app->user->getIdentity()) {
            return $user->hasAccess(User::RULE_OWNER, ['model' => $this]);
        }
        return false;
    }

    public static function findChildren($parent_id)
    {
        return self::find()->andWhere(['parent_id' => (int)$parent_id]);
    }

    public static function findByStatus($status)
    {
        return self::find()->andWhere('status = :status', ['status' => $status]);
    }

    /**
     * Возвращает еще не проверенную, изменненую модель текущего места
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getNoCheckModel()
    {
        $model = self::findByStatus(AppConstants::STATUS['NO_MODERATE'])->andWhere(['parent_id' => $this->id])->one();
        return $model ? $model : null;
    }
    
    public function setStars() {
        $res = Review::getSumStarByPlace($this->id);
        if ($res) {
            $this->stars = round($res['sum'] / $res['count'], 1);
            $this->stars_count = $res['count'];
        }
    }
    
    public function getPlaceMenu() {

    }


}
