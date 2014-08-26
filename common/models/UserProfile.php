<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\web\User;

/**
 * This is the model class for table "cd_user_profile".
 *
 * @property integer $user_id
 * @property string $real_name
 * @property string $birthday
 * @property string $website
 * @property string $location
 * @property integer $gender
 * @property string $avatar_url
 * @property string $desc
 * @property integer $data_reputation
 * @property integer $data_money
 *
 * @property User $user
 */
class UserProfile extends \yii\db\ActiveRecord
{
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
            [['user_id', 'gender', 'data_reputation', 'data_money'], 'integer'],
            [['desc'], 'string'],
            [['real_name'], 'string', 'max' => 30],
            [['birthday'], 'string', 'max' => 10],
            [['website', 'location'], 'string', 'max' => 100],
            [['avatar_url'], 'string', 'max' => 250],
            [['url'], 'url'],
            [['user_id'], 'unique'],
            [['desc'], 'filter', 'filter'=>'trim'],
            [['gender'], 'in', 'range' => static::genders()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'real_name' => 'Real Name',
            'birthday' => 'Birthday',
            'website' => 'Website',
            'location' => 'Location',
            'gender' => 'Gender',
            'avatar_url' => 'Avatar Url',
            'desc' => 'Desc',
            'data_reputation' => 'Data Reputation',
            'data_money' => 'Data Money',
        ];
    }

    public static function find()
    {
        return new UserProfileQuery(get_called_class());
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
}


class UserProfileQuery extends ActiveQuery
{

}
