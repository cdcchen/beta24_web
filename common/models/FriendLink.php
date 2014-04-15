<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "cd_link".
 *
 * @property string $id
 * @property string $name
 * @property string $url
 * @property string $logo
 * @property string $desc
 * @property string $orderid
 * @property integer $ishome
 */
class FriendLink extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{friend_link}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['orderid', 'ishome'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['url', 'logo', 'desc'], 'string', 'max' => 250],
            [['name'], 'unique'],
            [['url'], 'unique']
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
            'url' => 'Url',
            'logo' => 'Logo',
            'desc' => 'Desc',
            'orderid' => 'Orderid',
            'ishome' => 'Ishome',
        ];
    }
}
