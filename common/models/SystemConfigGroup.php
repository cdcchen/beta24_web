<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cd_config_group".
 *
 * @property integer $id
 * @property string $name
 * @property string $desc
 * @property integer $order_id
 */
class SystemConfigGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return TBL_CONFIG_GROUP;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['desc'], 'string', 'max' => 250],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'desc' => 'Desc',
            'order_id' => 'Order ID',
        ];
    }
}
