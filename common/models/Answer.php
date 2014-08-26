<?php

namespace common\models;

use Yii;
use common\behaviors\IPAddressBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

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
 *
 * @property \common\models\User $user
 * @property array|AnswerComment[] $comments
 * @property Question $question
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
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            IPAddressBehavior::className(),
        ];
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

    /**
     * @inheritdoc
     * @return AnswerQuery|ActiveQuery
     */
    public static function find()
    {
        return new AnswerQuery(get_called_class());
    }


    /******************** Relational Data ***********************/

    /**
     * Answer has_one Question via Question.id -> question_id
     * @return QuestionQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'question_id'])
            ->inverseOf('answers');
    }

    /**
     * Answer has_many AnswerComment via AnswerComment.answer_id -> id
     * @return AnswerCommentQuery
     */
    public function getComments()
    {
        return $this->hasMany(AnswerComment::className(), ['answer_id' => 'id'])
            ->inverseOf('answer');
    }

    /**
     * Answer has_one User via user.id -> user_id
     * @return UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id'])
            ->inverseOf('answers');
    }
}


class AnswerQuery extends ActiveQuery
{
    public function setQuestionID($id)
    {
        $this->andWhere('question_id = :question_id', [':question_id' => $id]);
        return $this;
    }

    public function setUserID($id)
    {
        $this->andWhere('user_id = :user_id', [':user_id' => $id]);
        return $this;
    }
}
