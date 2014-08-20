<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use common\behaviors\IPAddressBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\db\ActiveQuery;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $display_name
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $phone
 * @property string $auth_key
 * @property integer $created_at
 * @property string $created_ip
 * @property integer $updated_at
 * @property string $updated_ip
 * @property integer $status
 * @property string $password write-only password
 *
 * @property array $questions Question model array
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = -1;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 10;

    public static function statuses()
    {
        return [
            self::STATUS_ACTIVE,
            self::STATUS_INACTIVE,
            self::STATUS_DELETED,
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return TBL_USER;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            IPAddressBehavior::className(),
        ];
    }

    /**
      * @inheritdoc
      */
    public function rules()
    {
        return [
            [['username', 'display_name', 'email'], 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            [['username', 'display_name'], 'string', 'max'=>50],
            [['display_name', 'email', 'phone'], 'unique'],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED, self::STATUS_INACTIVE]],

            ['email', 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '账号',
            'display_name' => '昵称',
            'password' => '密码(明文)',
            'password_hash' => '密码(密文)',
            'password__reset_token' => '重设密码token',
            'email' => '邮箱',
            'phone' => '电话',
            'auth_key' => 'Auth Key',
            'created_at' => '创建时间',
            'created_ip' => '创建IP',
            'updated_at' => '更新时间',
            'updated_ip' => '更新IP',
            'status' => '状态',
        ];
    }

    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /******************** Relational Data ***********************/

    public function getQuestions()
    {
        return $this->hasMany(Question::className(), ['user_id' => 'id'])
            ->inverseOf('user');
    }


    /******************** IdentityInterface  *********************/

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
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
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = security()->generateRandomString();
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return security()->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = security()->generatePasswordHash($password);
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = security()->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}



class UserQuery extends ActiveQuery
{
    public function status($status)
    {
        $this->andWhere(['status' => $status]);
        return $this;
    }

    public function active()
    {
        $this->andWhere(['status' => User::STATUS_ACTIVE]);
        return $this;
    }

    public function inactive()
    {
        $this->andWhere(['status' => User::STATUS_INACTIVE]);
        return $this;
    }

    public function deleted()
    {
        $this->andWhere(['status' => User::STATUS_DELETED]);
        return $this;
    }
}