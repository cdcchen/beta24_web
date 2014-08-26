<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "cd_user_config".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $config_name
 * @property string $config_value
 * @property integer $config_type
 * @property string $name
 * @property string $desc
 *
 * @property \common\models\User $user
 */
class UserConfig extends \yii\db\ActiveRecord
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
            [['user_id', 'config_name', 'config_value', 'config_type', 'name'], 'required'],
            [['user_id', 'config_type'], 'integer'],
            [['config_value', 'desc'], 'string'],
            [['config_name'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 50],
            [['config_name', 'name', 'desc'], 'filter', 'filter' => 'trim'],
            [['config_name'], 'unique', 'targetAttribute' => ['user_id', 'config_name']]
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
            'config_name' => '变量名',
            'config_value' => '变量值',
            'config_type' => '变量类型',
            'name' => '变量名称',
            'desc' => '备注',
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


    /**
     * @param $userID user id
     * @param $name config name
     * @return UserConfig | null
     */
    public static function findByUserIDConfigName($userID, $name)
    {
        return static::findOne(['user_id' => $userID, 'config_name' => $name]);
    }

}


class UserConfigQuery extends ActiveQuery
{
    public function setUserID($id)
    {
        $this->andWhere('user_id = :user_id', [':user_id' => $id]);
        return $this;
    }
}
