<?php

namespace common\models;

use common\base\DateTimeTrait;
use Yii;
use yii\db\ActiveQuery;
use common\models\User;

/**
 * This is the model class for table "cd_user_profile".
 *
 * @property integer $user_id
 * @property string $real_name
 * @property string $birth_year
 * @property string $birth_month
 * @property string $birth_day
 * @property string $website
 * @property string $location_province
 * @property string $location_city
 * @property integer $gender
 * @property string $avatar_url
 * @property string $desc
 * @property integer $data_reputation
 * @property integer $data_money
 * @property string $im_qq
 *
 * @property \common\models\User $user
 */
class UserProfile extends \yii\db\ActiveRecord
{
    use DateTimeTrait;

    const GENDER_UNKNOWN = 0;
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    public static function genders()
    {
        return [self::GENDER_UNKNOWN, self::GENDER_FEMALE, self::GENDER_MALE];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return TBL_USER_PROFILE;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'gender', 'data_reputation', 'data_money', 'birth_year', 'birth_month', 'birth_day', 'location_province', 'location_city'], 'integer'],
            [['real_name'], 'string', 'max' => 30],
            [['im_qq'], 'string', 'max' => 30],
            [['website', 'avatar_url'], 'string', 'max' => 250],
            [['website'], 'url'],
            [['user_id'], 'unique'],
            [['desc'], 'filter', 'filter'=>'trim'],
            [['gender'], 'in', 'range' => static::genders()],
            [['desc'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => '用户ID',
            'real_name' => '真实姓名',
            'birth_year' => '生日',
            'birth_month' => '生日',
            'birth_day' => '生日',
            'website' => '个人网址',
            'location_province' => '省份',
            'location_city' => '城市',
            'gender' => '性别',
            'avatar_url' => '头像',
            'desc' => '简介',
            'data_reputation' => '声望',
            'data_money' => '金币',
            'im_qq' => 'QQ',
        ];
    }

    public static function find()
    {
        return new UserProfileQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        $fields = parent::fields();

        $fields['birthday'] = [$this, 'getBirthday'];
        $fields['location'] = [$this, 'getLocation'];

        return $fields;
    }


    /******************** Relational Data ***********************/

    /**
     * UserProfile has_one User via User.id -> user_id
     * @return UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    /******************** get function ***********************/

    /**
     * @return null|string Full birthday description
     */
    public function getBirthday()
    {
        return ($this->birth_year && $this->birth_month && $this->birth_day)
            ? $this->birth_year . '-' . $this->birth_month . '-' .  $this->birth_day
            : null;
    }

    public function getLocation()
    {
        if ($this->location_province && $this->location_city)
            return $this->location_province . '省' . $this->location_city . '市';
        else
            return null;
    }
}


class UserProfileQuery extends ActiveQuery
{
    /**
     * @param int $min
     * @param int $max
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function reputation($min, $max = 0)
    {
        $min = (int)$min;
        $max = (int)$max;

        if ($max === 0)
            $this->andWhere('data_reputation > :min', [':min' => $min]);
        elseif ($min >= (int)$max)
            throw new \InvalidArgumentException('Min must be less than max.');
        else
            $this->andWhere('between', 'score', $min, (int)$max);

        return $this;
    }

    /**
     * @param int $min
     * @param int $max
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function money($min, $max = 0)
    {
        $min = (int)$min;
        $max = (int)$max;

        if ($max === 0)
            $this->andWhere('data_money > :min', [':min' => $min]);
        elseif ($min >= (int)$max)
            throw new \InvalidArgumentException('Min must be less than max.');
        else
            $this->andWhere('between', 'score', $min, (int)$max);

        return $this;
    }
}
