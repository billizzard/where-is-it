<?php

namespace app\models;

use app\components\file\FileHelper;
use app\components\file\ImagePlaceHandler;
use app\constants\AppConstants;
use app\constants\ImageConstants;
use app\models\traits\UrlImageUploader;
use voskobovich\linker\LinkerBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%place}}".
 *
 * @property integer id
 * @property string name
 * @property string description
 * @property integer status
 * @property integer user_id
 * @property integer yes
 * @property integer no
 * @property integer type
 * @property double lat
 * @property double lon
 * @property string address
 * @property string dir
 * @property string created_ip
 * @property string prev_description
 * @property integer created_at
 * @property integer updated_at
 * @property integer parent_id
 * @property integer stars
 * @property integer stars_count
 * @property boolean is_deleted
 * @property Category[] categories
 */

class Place extends BaseModel
{
    use UrlImageUploader;

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
            [['name', 'lat', 'lon', 'category_ids'], 'required'],
            [['lat', 'lon'], 'number'],
            [['yes', 'no', 'type', 'status', 'user_id', 'parent_id', 'stars_count'], 'integer'],
            [['name', 'address'], 'string', 'max' => 255],
            [['dir'], 'string', 'max' => 100],
            [['stars'], 'number', 'min' => 0, 'max' => 5],
            [['description'], 'string', 'max' => 1500],
            [['prev_description'], 'string', 'max' => 500],
            [['is_deleted'], 'boolean'],
            [['category_ids'], 'categoryValidate'],

            //[['category_ids'], 'each', 'rule' => ['integer']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
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
            'prev_description' => 'Краткое описание',
            'created_ip' => 'ip создателя',
            'status' => 'Статус',
            'parent_id' => 'Родитель',
            'is_deleted' => 'Удалено ли',
            'category_ids' => 'Категории',
        ];
    }

    public function attributeForParent() {
        return [
            'name',
            'lat',
            'lon',
            'address',
            'description',
            'prev_description',
            'category_ids',
        ];
    }

    public function isCanAddMore() {
        if ($this->parent_id) {
            $count = self::find()->andWhere(['parent_id' => $this->parent_id])->count();
            return $count < AppConstants::COUNT_COPIES;
        }
        return true;
    }

    /**
     * Можно ли обновлять модель, так как создается новая модель
     * @return bool
     */
    public function isUpdatable() {
        return $this->isCanAddMore();
    }

    public function categoryValidate($attribute, $params)
    {
        if ($this->{$attribute}) {
            if (count($this->{$attribute}) > 3) {
                $this->addError($attribute, 'Нельзя выбрать больше 3');
            }
        }
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
            if ($image = $this->getMainImage()->one()) {
                $image->delete();
            }
            FileHelper::removeDir($dir);
        }
        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }

    /**
     * Возвращает Места для карты в зависимости от категории и размеров карты
     * @param $category_id
     * @param $size
     * @return mixed
     */
    public static function getForMapByCategoryId($category_id, $size) {
        $category_id = (int)$category_id;
        $latMin = $size[0][0];
        $latMax = $size[1][0];
        $lonMin = $size[0][1];
        $lonMax = $size[1][1];

        return self::findByStatus()
            ->leftJoin('category_place', 'category_place.place_id = place.id')
            ->leftJoin('image', 'image.place_id = place.id AND image.type = 0')
            ->andWhere(
                'lat >= :latMin AND lat <= :latMax AND lon >= :lonMin AND lon <= :lonMax AND category_place.category_id = :category_id AND place.parent_id = 0',
                ['latMin' => $latMin, 'latMax' => $latMax, 'lonMin' => $lonMin, 'lonMax' => $lonMax, 'category_id' => $category_id])

            ->select(['place.id', 'name', 'lat', 'lon', 'yes', 'no', 'place.type', 'place.prev_description', 'address',
                'updated_at', 'image.url', 'stars', 'stars_count'])->asArray()->all();

    }

    public static function findByStatus($status = AppConstants::STATUS['MODERATE']) {
        return self::find()->andWhere(['place.status' =>(int)$status]);
    }

    public static function findByIdAndStatus($id, $status = AppConstants::STATUS['MODERATE']) {
        return self::findByStatus($status)->andWhere(['id' => (int)$id]);
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                //'updatedAtAttribute' => false
            ],
            [
                'class' => LinkerBehavior::className(),
                'relations' => [
                    'category_ids' => 'categories',
                ],
            ],
        ];
    }


    public function getMainImage()
    {
        return $this->hasOne(Image::className(), ['place_id' => 'id'])->andWhere(['image.type' => ImageConstants::TYPE['MAIN_PLACE']]);
    }

    public function getGallery()
    {
        return $this->hasMany(Gallery::className(), ['place_id' => 'id'])->andWhere(['gallery.status' => AppConstants::STATUS['MODERATE']]);
    }

    public function getDiscounts()
    {
        return $this->hasMany(Discount::className(), ['place_id' => 'id'])->andWhere(['discount.status' => AppConstants::STATUS['MODERATE']]);
    }

    public function getReviews()
    {
        return $this->hasMany(Review::className(), ['place_id' => 'id'])->andWhere(['review.status' => AppConstants::STATUS['MODERATE']]);
    }

    public function getSchedule() {
        return $this->hasOne(Schedule::className(), ['place_id' => 'id'])->andWhere(['schedule.status' => AppConstants::STATUS['MODERATE']]);
    }

    public function getContact() {
        return $this->hasOne(Contact::className(), ['place_id' => 'id'])->andWhere(['contact.status' => AppConstants::STATUS['MODERATE']]);
    }

    public function getCategories() {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])
            ->viaTable('category_place', ['place_id' => 'id']);
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

    public function getPrevDescription() {
        return $this->prev_description;
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
    
    public function setStars() {
        $res = Review::getSumStarByPlace($this->id);
        if ($res) {
            $this->stars = round($res['sum'] / $res['count'], 1);
            $this->stars_count = $res['count'];
        }
    }


}
