<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cd_answer_comment".
 *
 * @property string $id
 * @property string $answer_id
 * @property string $user_id
 * @property integer $created_at
 * @property string $created_ip
 * @property integer $score
 * @property string $content
 */
class AnswerComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return TBL_ANSWER_COMMENT;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['answer_id', 'user_id', 'created_at', 'score'], 'integer'],
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
            'id' => 'ID',
            'answer_id' => 'Answer ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'created_ip' => 'Created Ip',
            'score' => 'Score',
            'content' => 'Content',
        ];
    }
}
