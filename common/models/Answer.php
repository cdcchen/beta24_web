<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cd_answer".
 *
 * @property string $id
 * @property string $question_id
 * @property string $user_id
 * @property integer $created_at
 * @property string $created_ip
 * @property integer $updated_at
 * @property string $updated_ip
 * @property integer $vote_up
 * @property integer $vote_down
 * @property string $content
 */
class Answer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return TBL_ANSWER;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_id', 'user_id', 'created_at', 'updated_at', 'vote_up', 'vote_down'], 'integer'],
            [['content'], 'string'],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question_id' => 'Question ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'created_ip' => 'Created Ip',
            'updated_at' => 'Updated At',
            'updated_ip' => 'Updated Ip',
            'vote_up' => 'Vote Up',
            'vote_down' => 'Vote Down',
            'content' => 'Content',
        ];
    }
}
