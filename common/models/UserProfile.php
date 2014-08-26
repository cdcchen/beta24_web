<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cd_user_profile".
 *
 * @property string $user_id
 * @property string $real_name
 * @property string $birthday
 * @property string $website
 * @property string $location
 * @property integer $gender
 * @property string $avatar_url
 * @property string $desc
 * @property integer $data_reputation
 * @property integer $data_money
 */
class UserProfile extends \yii\db\ActiveRecord
{
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
            [['user_id'], 'unique']
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
}
