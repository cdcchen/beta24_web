<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;

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
 *
 * @property SystemConfigGroup $group
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
            [['group_id', 'config_name', 'config_value', 'config_type', 'name'], 'required'],
            [['group_id', 'config_type', 'order_id'], 'integer'],
            [['config_value', 'desc'], 'string'],
            [['config_name'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 50],
            [['config_name', 'name', 'desc'], 'filter', 'filter' => 'trim'],
            [['config_name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_id' => '组ID',
            'config_name' => '变量名',
            'config_value' => '变量值',
            'config_type' => '变量类型',
            'name' => '变量名称',
            'desc' => '备注',
        ];
    }

    /**
     * @inheritdoc
     * @return SystemConfigQuery|ActiveQuery
     */
    public static function find()
    {
        return new SystemConfigQuery(get_called_class());
    }


    /******************** Relational Data ***********************/

    /**
     * @return SystemConfigGroupQuery
     */
    public function getGroup()
    {
        return $this->hasOne(SystemConfigGroup::className(), ['id' => 'group_id'])
            ->inverseOf('configs');
    }


    /**
     * @param $name config_name
     * @return SystemConfig|null
     */
    public static function findByConfigName($name)
    {
        return static::findOne(['config_name' => $name]);
    }
}


class SystemConfigQuery extends ActiveQuery
{
    public function search($kw, $or = true)
    {
        $this->andWhere([$or ? 'or like' : 'like', 'config_name', $kw]);
        return $this;
    }
}