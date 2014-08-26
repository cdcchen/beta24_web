<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cd_feedback".
 *
 * @property string $id
 * @property string $user_id
 * @property integer $created_at
 * @property string $created_ip
 * @property string $content
 */
class Feedback extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return TBL_FEED_BACK;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at'], 'integer'],
            [['content'], 'string'],
            [['created_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '	',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'created_ip' => 'Created Ip',
            'content' => 'Content',
        ];
    }
}
