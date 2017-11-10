<?php

namespace app\models;

use app\components\Helper;
use app\components\SiteException;
use app\constants\ImageConstants;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer id
 * @property string name
 * @property string email
 * @property string password
 * @property string access_token
 * @property string auth_key
 * @property string login
 * @property integer role
 * @property integer created_at
 * @property integer updated_at
 * @property boolean is_deleted
 */

class User extends BaseModel implements \yii\web\IdentityInterface
{
    const ROLE_GUEST = 0;
    const ROLE_ADMIN = 1;
    const ROLE_OWNER = 2;

    const RULE_ADMIN_PANEL = 1;
    const RULE_DELETE_USER = 2;
    const RULE_OWNER = 3;
    const RULE_DELETE_MODEL_FULL = 4;

    public $loginUrl = ['/auth/'];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            [['updated_at', 'created_at', 'role'], 'integer'],
            [['password', 'access_token', 'auth_key'], 'string', 'max' => 200],
            [['login'], 'string', 'max' => 50],
            [['login', 'email'], 'unique'],
            [['name'], 'string', 'max' => 100],
            [['email'], 'email'],
            [['is_deleted'], 'boolean'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'password' => 'Пароль',
            'email' => 'Электронная почта',
            'name' => 'Имя',
            'login' => 'Логин',
            'created_at' => 'Дата регистрации',
            'updated_at' => 'Дата изменния',
            'is_deleted' => 'Удалено ли',
        ];
    }


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $email
     * @return object|null
     */
    public static function findByEmail($email)
    {
        $user = self::find()->andWhere('email = :email', ['email' => $email])->one();

        return $user;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password);
    }

    public function getRole() {
        return $this->role;
    }

    /**
     * Проверяет является ли пользователь админом
     * @return bool
     */
    public function isAdmin() {
        return $this->getRole() == self::ROLE_ADMIN;
    }

    /**
     * Проверяет, может ли пользователь выполнять определенное действие
     * @param $rule
     * @return bool
     */
    public function hasAccess($rule, $data = []) {
        switch($rule) {
            case self::RULE_DELETE_USER: return $this->isAdmin(); break;
            case self::RULE_ADMIN_PANEL: return $this->isAdmin(); break;
            case self::RULE_DELETE_MODEL_FULL: return $this->isAdmin(); break;
            case self::RULE_OWNER:
                if ($this->isAdmin()) return true;
                if ($data['model']) {
                    if ($data['model']->hasAttribute('user_id')) {
                        return $this->getId() === $data['model']->getUserId();
                    } else if ($data['model']->hasAttribute('place_id')) {
                        $place = $data['model']->place;
                        if ($place && $place->getUserId()) {
                            return $this->getId() === $place->getUserId();
                        }
                    }
                }
                return false;
                break;
        }
        return false;
    }

    public function setPassword($password) {
        $this->password = \Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey() {
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }

    public function isCanPostReviewOnPlace($place_id) {
        $review = Review::findByPlaceAndUserId($place_id, $this->id)->orderBy(['created_at' => SORT_DESC])->one();
        if ($review) {
            if ($review->created_at > (time() - 60*60*24)) {
                Helper::setMessage('Разрешено не более одного отзыва в сутки на место.');
                return false;
            }
        }
        return true;
    }
}
