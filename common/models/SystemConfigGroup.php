<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "cd_config_group".
 *
 * @property integer $id
 * @property string $name
 * @property string $desc
 * @property integer $order_id
 *
 * @property array|SystemConfig[] $configs
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
            [['name'], 'required'],
            [['order_id'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['desc'], 'string', 'max' => 250],
            [['name', 'desc'], 'filter', 'filter'=>'trim'],
            [['name', 'desc'], 'filter', 'filter'=>'strip_tags'],
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
            'name' => '名称',
            'desc' => '备注',
            'order_id' => '排序ID',
        ];
    }

    /**
     * @inheritdoc
     * @return SystemConfigGroupQuery|ActiveQuery
     */
    public static function find()
    {
        return new SystemConfigGroupQuery(get_called_class());
    }


    /******************** Relational Data ***********************/

    /**
     * @return SystemConfigQuery
     */
    public function getConfigs()
    {
        return $this->hasMany(SystemConfig::className(), ['group_id' => 'id']);
    }
}


class SystemConfigGroupQuery extends ActiveQuery
{

}
