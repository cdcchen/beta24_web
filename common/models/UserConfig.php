<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cd_user_config".
 *
 * @property string $id
 * @property string $user_id
 * @property string $config_name
 * @property string $config_value
 * @property integer $config_type
 * @property string $name
 * @property string $desc
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
            [['user_id', 'config_type'], 'integer'],
            [['config_value', 'desc'], 'string'],
            [['config_name'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 50],
            [['config_name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'config_name' => 'Config Name',
            'config_value' => 'Config Value',
            'config_type' => 'Config Type',
            'name' => 'Name',
            'desc' => 'Desc',
        ];
    }
}
