<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cd_friend_link".
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property string $logo
 * @property string $desc
 * @property integer $order_id
 * @property integer $recommend
 */
class FriendLink extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return TBL_FRIEND_LINK;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'recommend'], 'integer'],

            [['name'], 'string', 'max' => 50],
            [['name', 'url', 'desc'], 'filter', 'filter'=>'trim'],
            [['name', 'url', 'desc'], 'filter', 'filter'=>'strip_tags'],
            [['name'], 'unique'],

            [['url', 'logo', 'desc'], 'string', 'max' => 250],
            [['url'], 'unique'],
            [['url'], 'url'],
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
            'url' => 'URL',
            'logo' => 'Logo',
            'desc' => '描述',
            'order_id' => '排序ID',
            'recommend' => '推荐',
        ];
    }
}
