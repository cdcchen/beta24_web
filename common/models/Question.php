<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "cd_question".
 *
 * @property string $id
 * @property string $user_id
 * @property string $title
 * @property string $view_count
 * @property string $favorite_count
 * @property string $answer_count
 * @property string $vote_count
 * @property string $bounty
 * @property integer $create_time
 * @property string $create_ip
 * @property integer $locked
 * @property string $tags
 * @property string $content
 */
class Question extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{question}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'view_count', 'favorite_count', 'answer_count', 'vote_count', 'bounty', 'create_time', 'locked'], 'integer'],
            [['content'], 'string'],
            [['title', 'tags'], 'string', 'max' => 250],
            [['create_ip'], 'string', 'max' => 15]
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
            'title' => 'Title',
            'view_count' => 'View Count',
            'favorite_count' => 'Favorite Count',
            'answer_count' => 'Answer Count',
            'vote_count' => 'Vote Count',
            'bounty' => 'Bounty',
            'create_time' => 'Create Time',
            'create_ip' => 'Create Ip',
            'locked' => 'Locked',
            'tags' => 'Tags',
            'content' => 'Content',
        ];
    }
}
