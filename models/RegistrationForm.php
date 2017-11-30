<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class RegistrationForm extends User
{
    public $email;
    public $password;
    public $login;
    public $is_deleted = false;

    public static function tableName()
    {
        return 'user';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'password', 'login'], 'required'],
            [['email'], 'email'],
            [['is_deleted'], 'boolean'],
            [['login', 'email'], 'string', 'max' => 50],
            [['login', 'email'], 'unique'],
        ];
    }

    public function registration() {
        $user = new User();
        $user->email = $this->email;
        $user->login = $this->login;
        $user->setPassword($this->password);
        return $user->save() ? $user : null;
    }
}
