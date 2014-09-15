<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $display_name;
    public $email;
    public $phone;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'filter', 'filter' => 'trim'],
            [['username', 'email', 'display_name', 'password'], 'required'],
            [['username'], 'string', 'min' => 2, 'max' => 50],
            [['password'], 'string', 'min' => 6],
            [['email'], 'email'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => '账号名已经被注册过了。'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => '邮箱已经被使用过了。'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => '账号',
            'email' => '邮箱',
            'phone' => '手机号',
            'password' => '密码',
            'display_name' => '昵称',
        ];
    }

    public function beforeValidate()
    {
        if (empty($this->username))
            $this->username = $this->email;

        return true;
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->display_name = $this->display_name;
            $user->password = $this->password;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->save();
            return $user;
        }

        return null;
    }
}
