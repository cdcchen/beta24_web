<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cd_config_item".
 *
 * @property integer $id
 * @property integer $group_id
 * @property string $config_name
 * @property string $config_value
 * @property integer $config_type
 * @property string $name
 * @property integer $order_id
 * @property string $desc
 */
class SystemConfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return TBL_CONFIG_ITEM;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'config_type', 'order_id'], 'integer'],
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
            'group_id' => 'Group ID',
            'config_name' => 'Config Name',
            'config_value' => 'Config Value',
            'config_type' => 'Config Type',
            'name' => 'Name',
            'order_id' => 'Order ID',
            'desc' => 'Desc',
        ];
    }
}
