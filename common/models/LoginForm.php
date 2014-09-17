<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    const REMEMBER_ACCOUNT_SESSION_NAME = '__remember_account';

    public $username;
    public $password;
    public $rememberAccount = true;
    public $rememberMe = true;

    private $_user = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $rememberAccount = session()->get(self::REMEMBER_ACCOUNT_SESSION_NAME);
        if ($rememberAccount)
            $this->username = $rememberAccount;

    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            [['rememberMe', 'rememberAccount'], 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    public function attributeLabels()
    {
        return [
            'username' => '账号',
            'password' => '密码',
            'rememberAccount' => '记住账号',
            'rememberMe' => '下次自动登录',
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            if ($this->rememberAccount) {
                session()->set(self::REMEMBER_ACCOUNT_SESSION_NAME, $this->username);
            }

            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        else {
            return false;
        }
    }



    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
