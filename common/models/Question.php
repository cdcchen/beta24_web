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
 * @property integer $vote_up
 * @property integer $vote_down
 * @property integer $answer_reputation
 * @property integer $open_bounty
 * @property integer $open_bounty_end_time
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

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return TBL_QUESTION;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'view_count', 'favorite_count', 'answer_count', 'vote_up', 'vote_down', 'open_bounty', 'open_bounty_end_time', 'answer_reputation', 'created_at', 'updated_at', 'status'], 'integer'],
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
            'user_id' => '用户ID',
            'title' => '标题',
            'view_count' => '浏览数',
            'favorite_count' => '收藏数',
            'answer_count' => '回答数',
            'vote_up' => '支持数',
            'vote_down' => '反对数',
            'open_bounty' => '赏金',
            'open_bounty_end_time' => '悬赏结束时间',
            'answer_reputation' => '需要声望',
            'created_at' => '创建时间',
            'created_ip' => '创建IP',
            'updated_at' => '更新时间',
            'updated_ip' => '更新IP',
            'status' => '状态',
            'tags' => '标签',
            'content' => '内容',
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
