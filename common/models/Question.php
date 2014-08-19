<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "cd_question".
 *
 * @property string $id
 * @property integer $user_id
 * @property string $title
 * @property integer $view_count
 * @property integer $favorite_count
 * @property integer $answer_count
 * @property integer $vote_count
 * @property integer $bounty
 * @property integer $created_at
 * @property string $created_ip
 * @property integer $updated_time
 * @property string $updated_ip
 * @property integer $status
 * @property string $tags
 * @property string $content
 *
 * @property User $user
 */
class Question extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 10;
    const STATUS_DONE = 1;
    const STATUS_DELETED = -1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%question}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'view_count', 'favorite_count', 'answer_count', 'vote_count', 'bounty', 'created_at', 'updated_at', 'status'], 'integer'],
            [['content'], 'string'],
            [['title', 'tags'], 'string', 'max' => 250],
            [['create_ip', 'updated'], 'string', 'max' => 15]
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
            'created_at' => '创建时间',
            'created_ip' => '创建IP',
            'updated_at' => '更新时间',
            'updated_ip' => '更新IP',
            'status' => '状态',
            'tags' => 'Tags',
            'content' => 'Content',
        ];
    }

    public static function find()
    {
        return new QuestionQuery(get_called_class());
    }


    /******************** Relational Data ***********************/

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id'])->inverseOf('questions');
    }
}


class QuestionQuery extends ActiveQuery
{
    public function status($status)
    {
        $this->andWhere(['status' => $status]);
        return $this;
    }

    public function active()
    {
        $this->andWhere(['status' => Question::STATUS_ACTIVE]);
        return $this;
    }

    public function done()
    {
        $this->andWhere(['status' => Question::STATUS_DONE]);
        return $this;
    }

    public function deleted()
    {
        $this->andWhere(['status' => Question::STATUS_DELETED]);
        return $this;
    }
}
