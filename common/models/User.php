<?php
namespace common\models;

use common\base\DateTimeTrait;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use common\behaviors\IPAddressBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Url;
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
 * __get property
 * @property string $displayName
 * @property string $homeUrl
 *
 * Relations
 * @property array|Question[] $questions user's question
 * @property array|QuestionComment[] $questionComments user's question comments
 * @property UserProfile $profile
 * @property array|Answer[] $answers
 * @property array|AnswerComment[] $answerComments
 * @property array|UserConfig[] $configs
 */
class User extends ActiveRecord implements IdentityInterface
{
    use DateTimeTrait;

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
    public function rules()
    {
        return [
            [['username', 'display_name', 'email'], 'filter', 'filter' => 'trim'],
            [['username', 'password', 'password_hash'], 'required'],
            [['username', 'display_name'], 'string', 'max'=>50],
            [['display_name', 'email', 'phone'], 'unique'],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => static::statuses()],

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

    /**
     * @inheritdoc
     */
    public function fields()
    {
        $fields = parent::fields();
        unset($fields['auth_key'], $fields['password'], $fields['password_hash'], $fields['password__reset_token'], $fields['created_at'], $fields['updated_at']);

        $fields['createdAt'] =  [$this, 'getCreatedAt'];
        $fields['updatedAt'] =  [$this, 'getUpdatedAt'];
        $fields['displayName'] = [$this, 'getDisplayName'];
        $fields['homeUrl'] = [$this, 'getHomeUrl'];

        return $fields;
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
     * @return UserQuery|ActiveQuery
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /******************** Relational Data ***********************/

    /**
     * User has_many Question via Question.user_id -> id
     * @return QuestionQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Question::className(), ['user_id' => 'id'])
            ->inverseOf('user');
    }

    /**
     * User has_many QuestionComment via QuestionComment.user_id -> id
     * @return array|QuestionComment[]
     */
    public function getQuestionComments()
    {
        return $this->hasMany(QuestionComment::className(), ['user_id' => 'id'])
            ->inverseOf('user');
    }

    /**
     * User has_many Answer via Answer.user_id -> id
     * @return AnswerQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['user_id' => 'id'])
            ->inverseOf('user');
    }

    /**
     * User has_many AnswerComment via AnswerComment.user_id -> id
     * @return array|AnswerComment[]
     */
    public function getAnswerComments()
    {
        return $this->hasMany(AnswerComment::className(), ['user_id' => 'id'])
            ->inverseOf('user');
    }

    /**
     * User has_one UserProfile via UserProfile.user_id -> id
     * @return UserProfile
     */
    public function getProfile()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id'])
            ->inverseOf('user');
    }

    /**
     * User has_many UserConfig via UserConfig.user_id -> id
     * @return UserConfigQuery
     */
    public function getConfigs()
    {
        return $this->hasMany(UserConfig::className(), ['user_id' => 'id'])
            ->inverseOf('user');
    }


    /******************** __get function ***************************/

    public function getDisplayName()
    {
        return $this->display_name ? $this->display_name : $this->username;
    }

    public function getHomeUrl()
    {
        return Url::toRoute(['user/home', 'id' => $this->id, 'name'=>$this->getDisplayName()]);
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