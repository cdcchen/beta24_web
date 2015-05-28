<?php
namespace common\models;

use Yii;
use yii\base\InvalidParamException;
use yii\base\UserException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\IdentityInterface;
use yiiplus\behaviors\IPAddressBehavior;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $display_name
 * @property string $password_hash
 * @property string $email
 * @property string $phone
 * @property integer $status
 * @property integer $role
 * @property string $auth_key
 * @property string $password_reset_token
 * @property string $activate_token
 * @property string $access_token
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $created_ip
 * @property string $updated_ip
 * @property integer $source
 *
 * __get property
 * @property string $sourceLabel
 * @property string $statusLabel
 * @property string $roleLabel
 * @property string $homeUrl
 * @property string $displayName
 *
 * Relations
 * @property array|Question[] $questions user's question
 * @property array|Question[] $favorites user's favorite question
 * @property array|QuestionComment[] $questionComments user's question comments
 * @property UserProfile $profile
 * @property array|Answer[] $answers
 * @property array|AnswerComment[] $answerComments
 */
class User extends ActiveRecord implements IdentityInterface
{
    use DateTimeTrait, ColumnValueLabelsTrait;

    const STATUS_DELETED = -100;
    const STATUS_FORBIDDEN = -10;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 10;

    const ROLE_MEMBER = 0;
    const ROLE_STAFF = 100;

    const SOURCE_UNKNOWN = '未知';
    const SOURCE_PC_WEBSITE = 'PC站';
    const SOURCE_MOBILE_WEBSITE = '移动站';
    const SOURCE_IPHONE = 'iPhone客户端';
    const SOURCE_IPAD = 'iPad客户端';
    const SOURCE_ANDROID = '安卓客户端';
    const SOURCE_WEIXIN = '微信';

    public static $statusLabels = [
        self::STATUS_ACTIVE => '有效',
        self::STATUS_INACTIVE => '无效',
        self::STATUS_FORBIDDEN => '禁用',
        self::STATUS_DELETED => '删除',
    ];

    public static $roleLabels = [
        self::ROLE_MEMBER => '普通用户',
        self::ROLE_STAFF => '工作人员',
    ];

    public static $sourceLabels = [
        self::SOURCE_UNKNOWN => '未知',
        self::SOURCE_PC_WEBSITE => 'PC站',
        self::SOURCE_MOBILE_WEBSITE => '移动站',
        self::SOURCE_IPHONE => 'iPhone客户端',
        self::SOURCE_IPAD => 'iPad客户端',
        self::SOURCE_ANDROID => '安卓客户端',
        self::SOURCE_WEIXIN => '微信',
    ];

    public static function statuses($exclude = [])
    {
        return array_keys(static::statusLabels(null, $exclude));
    }

    public static function statusLabels($status = null, $exclude = [])
    {
        return static::valueLabels(self::$statusLabels, $status, $exclude);
    }

    public static function roles($exclude = [])
    {
        return array_keys(static::roleLabels(null, $exclude));
    }

    public static function roleLabels($role = null, $exclude = [])
    {
        return static::valueLabels(self::$roleLabels, $role, $exclude);
    }

    public static function sources($exclude = [])
    {
        return array_keys(static::sourceLabels(null, $exclude));
    }

    public static function sourceLabels($source = null, $exclude = [])
    {
        return static::valueLabels(self::$sourceLabels, $source, $exclude);
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
            [['username', 'password_hash', 'display_name'], 'required'],

            [['created_at', 'updated_at', 'role', 'status', 'source'], 'integer'],
            [['username', 'display_name', 'password_hash', 'password_reset_token', 'email', 'access_token'], 'string', 'max' => 100],
            [['activate_token'], 'string', 'max' => 500],
            [['created_ip', 'updated_ip'], 'string', 'length' => [7, 15]],
            [['phone'], 'match', 'pattern' => PATTERN_PHONE, 'message' => '不是有效的手机号'],
            [['email'], 'email'],

            [['username', 'display_name', 'email', 'phone'], 'trim'],

            ['status', 'in', 'range' => static::statuses()],
            ['role', 'in', 'range' => static::roles()],
            ['source', 'in', 'range' => static::sources()],

            [['username', 'display_name'], 'unique'],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['resetPassword'] = ['password_hash', 'updated_at', 'updated_ip', 'password_reset_token'];
        $scenarios['activateAccount'] = ['activate_token', 'status', 'updated_at', 'updated_ip'];
        $scenarios['updateBasic'] = ['display_name', 'email', 'phone', 'role', 'status', 'source', 'updated_at', 'updated_ip'];
        $scenarios['updateStatus'] = ['status', 'updated_at', 'updated_ip'];
        $scenarios['updateAccessToken'] = ['access_token', 'updated_at', 'updated_ip'];

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '账号',
            'display_name' => '昵名',
            'password_hash' => '密码',
            'password_reset_token' => '重设密码token',
            'activate_token' => '激活token',
            'access_token' => '访问token',
            'email' => '邮箱',
            'phone' => '电话',
            'auth_key' => 'Auth Key',
            'role' => '角色',
            'status' => '状态',
            'source' => '注册来源',
            'created_at' => '创建时间',
            'created_ip' => '创建IP',
            'updated_at' => '更新时间',
            'updated_ip' => '更新IP',
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        $fields = parent::fields();
        unset($fields['auth_key'], $fields['activate_token'], $fields['password_hash'], $fields['password_reset_token'], $fields['access_token']);
        $fields = array_merge($fields, ['statusLabel', 'roleLabel', 'sourceLabel', 'homeUrl', 'isStaff', 'createdAt', 'updatedAt']);

        return $fields;
    }

    public function extraFields()
    {
        $fields = parent::extraFields();
        $fields = array_merge($fields, ['profile', 'posts', 'comments']);

        return $fields;
    }

    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    public function beforeDelete()
    {
        throw new UserException('用户不允许删除');
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

    /**
     * Question has_many Tag via Tag.id -> question_tag.tag_id and question_tag.question_id -> id
     * @return TagQuery
     */
    public function getFavorites()
    {
        return $this->hasMany(Question::className(), ['id' => 'question_id'])
            ->viaTable(TBL_USER_QUESTION, ['user_id' => 'id']);
    }


    /******************** __get function ***************************/

    public function getDisplayName()
    {
        return $this->display_name;
    }

    public function getStatusLabel()
    {
        return static::statusLabels($this->status);
    }

    public function getSourceLabel()
    {
        return static::sourceLabels($this->source);
    }

    public function getRoleLabel()
    {
        return static::roleLabels($this->role);
    }

    public function getHomeUrl($scheme = true)
    {
        return Url::toRoute(['user/home', 'id' => $this->id], $scheme);
    }


    /******************** IdentityInterface  *********************/

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
        return static::findOne(['access_token' => $token]);
    }


    ##################### custom methods #############################

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
        if (!static::passwordResetTokenIsValid($token)) {
            return null;
        }

        return static::findOne(['password_reset_token' => $token, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by validate token
     *
     * @param string $token activate token
     * @return static|null
     */
    public static function findByActivateToken($token)
    {
        $data = static::parseActivateToken($token);
        if ($data === false) return null;

        // @todo 此处要根据token里的信息进行查询
        return static::findOne([
            'id' => $data['user_id'],
            'activate_token' => $token,
        ]);
    }

    public static function parseActivateToken($token)
    {
        $data = Json::decode(base64_decode($token));
        return is_numeric($data['user_id']) ? $data : false;
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function passwordResetTokenIsValid($token)
    {
        if (empty($token))  return false;

        $expire = param('user.password_reset_token_expire');
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= REQUEST_TIME;
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
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password_hash = security()->generatePasswordHash($password);
        return $this;
    }

    /**
     * Generates "remember me" authentication key
     * @return $this
     */
    public function generateAuthKey()
    {
        $this->auth_key = security()->generateRandomString();
        return $this;
    }

    /**
     * Generates new password reset token
     * @return $this
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = security()->generateRandomString() . '_' . param('user.password_reset_token_expire', REQUEST_TIME);
        return $this;
    }

    /**
     * Removes password reset token
     * @return $this
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = '';
        return $this;
    }

    /**
     * Generates activate account token
     * @return $this
     */
    public function generateActivateToken()
    {
        // @todo 这里需要设计此token包含的信息，暂时只有user_id一个字段，后续还应该加上签名验证。
        $data = [
            'user_id' => $this->id,
            'email_id' => md5($this->email),
        ];
        $this->activate_token = base64_encode(Json::encode($data));
        return $this;
    }

    /**
     * Removes password reset token
     * @return $this
     */
    public function removeValidateToken()
    {
        $this->activate_token = '';
        return $this;
    }

}



class UserQuery extends ActiveQuery
{
    use QueryScopeTrait;

    ############################# status ####################################

    public function status($status)
    {
        $this->columnEqualOrIn('status', $status);
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

    public function forbidden()
    {
        $this->andWhere(['status' => User::STATUS_FORBIDDEN]);
        return $this;
    }

    ############################# role ####################################

    public function role($role)
    {
        $this->columnEqualOrIn('role', $role);
        return $this;
    }

    public function isStaff()
    {
        $this->andWhere(['role' => User::ROLE_STAFF]);
        return $this;
    }

    public function isMember()
    {
        $this->andWhere(['role' => User::ROLE_MEMBER]);
        return $this;
    }

    public function source($source)
    {
        $this->columnEqualOrIn('source', $source);
        return $this;
    }

    public function createdAt($start = 0 , $end = 0)
    {
        $start = (int)$start;
        $end= (int)$end;

        if ($start < $end) {
            $this->andWhere(['between', 'created_at', $start, $end]);
            return $this;
        }
        else
            throw new InvalidParamException('$start must be less than $end.');
    }

    public function ipAddress($ip)
    {
        $ip = (array)$ip;
        if (isset($ip[1]))
            $this->andWhere(['in', 'create_ip', $ip]);
        else
            $this->andWhere(['create_ip' => $ip[0]]);

        return $this;
    }
}