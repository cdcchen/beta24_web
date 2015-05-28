<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "cd_user_config".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $key
 * @property string $value
 *
 * @property \common\models\User $user
 */
class UserConfig extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return TBL_USER_CONFIG;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'key', 'value'], 'required'],

            [['user_id'], 'integer'],
            [['key'], 'string', 'max' => 100],
            [['value'], 'string', 'max' => 1000],

            [['key'], 'match', 'pattern' => PATTERN_LETTER_NUMBER_UNDERLINE, 'message' => 'key 只能有字母数字和下划线组成。'],

            [['key'], 'trim'],

            [['key'], 'unique', 'targetAttribute' => ['user_id', 'key']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户ID',
            'key' => '选项名',
            'value' => '选项值',
        ];
    }

    /**
     * @inheritdoc
     * @return UserConfigQuery|ActiveQuery
     */
    public static function find()
    {
        return new UserConfigQuery(get_called_class());
    }


    /******************** Relational Data ***********************/

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id'])
            ->inverseOf('configs');
    }
}


class UserConfigQuery extends ActiveQuery
{
    public function userID($id)
    {
        $this->andWhere(['user_id' => $id]);
        return $this;
    }
}
